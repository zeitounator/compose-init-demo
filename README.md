# MVP compose init container demo

## Foreword
This example was crafter as an answer to [a StackOverflow question](https://stackoverflow.com/questions/70322031/does-docker-compose-support-init-container)
about using init containers with docker-compose.

According to [This PR](https://github.com/docker/compose-cli/issues/1499) the feature is available since docker-compose 1.29

Meanwhile, at time of this writing, it seems that it [has not made its full way to documentation](https://github.com/docker/docker.github.io/issues/12633)

## Example basics
The following example is far from perfect but was crafted to illustrate the concept. What it basically does is
1. spin up a mysql container
2. spin up an init container which will wait for db to be available (retries in executed bash script),
   create a db,a table and add some entries (from execusted bash script), then exit
3. spin up an application container (php/mysqli/apache) *which will only start once the init container has done
   its job*

## How to test
```bash
git clone 

```