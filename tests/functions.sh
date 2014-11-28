#!bin/bash
function get()
{
    url=$1
    output=$2
    if [ ${url:0:7} != "http://" ]
    then
        url="http://local.mysys.com$url"
    fi
    if [ "$output" = "" ]
    then
        output="./response.html"
    fi
    curl -b ./cookie -o $output $url
}

function post()
{
    url=$1
    post=$2
    response=$3
    if [ ${url:0:7} != "http://" ]
    then
        url="http://local.mysys.com$url"
    fi
    echo $url
    if [ "$response" = "" ]
    then
        response="./response.json"
    fi
    echo $response
    if [ "$post" = "" ]
    then
        curl -X POST -b ./cookie -o $response -c ./cookie $url
    else
        curl -X POST -b ./cookie -o $response -c ./cookie -d $post $url
    fi
}