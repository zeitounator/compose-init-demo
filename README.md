# MVP compose init container demo
<!--ts-->
   * [MVP compose init container demo](#mvp-compose-init-container-demo)
      * [Foreword](#foreword)
      * [Disclaimer](#disclaimer)
      * [Example basics](#example-basics)
      * [Prerequisite for running the demo](#prerequisite-for-running-the-demo)
      * [How to run the demo](#how-to-run-the-demo)

<!-- Added by: olcla, at: dim 12 déc 2021 19:29:59 CET -->

<!--te-->

## Foreword
This example was crafter as an answer to [a StackOverflow question](https://stackoverflow.com/questions/70322031/does-docker-compose-support-init-container)
about using init containers with docker-compose.

According to [This PR](https://github.com/docker/compose-cli/issues/1499) the feature is available since docker-compose 1.29

Meanwhile, at time of this writing, it seems that it [has not made its full way to documentation](https://github.com/docker/docker.github.io/issues/12633)

## Disclaimer
Please note this example is far from perfect and that the final target (i.e. getting the db initialized) can be
acheived without using an init container (the mysql image can perfectly do that out of the box). Meanwhile it was crafted
to illustrate the concept. The interesting part is that you can run many init task in the dedicated container and
wait for different services to be fully ready before you spin your final application containers.

## Example basics
What the example basically does is:
1. spin up a mysql container
2. spin up an init container which will wait for db to be available (retries in executed bash script),
   create a db,a table and add some entries (from execusted bash script), then exit
3. spin up an application container (php/mysqli/apache) *which will only start once the init container has fully done
   its job* and exists with a RC=0

## Prerequisite for running the demo
* A running docker installation with internet access
* Docker compose v1.29 or higher installed
* Free port 9999 on your local machine (else change the local port in `docker-compose.yml`)

## How to run the demo
```bash
git clone git@github.com:zeitounator/compose-init-demo.git
cd compose-init-demo
docker-compose up -d
```

On first run this will build a local image named `compose-ini-container_my_app` based on `php:apache` (this is just an
extension of the base image to add the mysqli driver used for demo)

You should then see the `db` container start, followed by the `init-db` container. At this point the process will wait
for the `db` container to fully end its job. This should take several seconds as the `initprojet.sh` script contains a
loop to wait for the mysql connection to be available prior to creating a scaffold db with some data.

Once the init container exists successfully, you should see the actual application container `my_app` start finally.
You can point your browser to http://localhost:9999/ to see the test page which will show the 3 rows that were created
by the init container

To clean-up the demo, simply run
```bash
docker-compose down -v
```