#!/bin/sh

# XXX update this path accordingly
wow_parent_path="/tmp"

###########################################################################
#                                                                         #
#                 Bigfoot WoW plugins Updater for Mac                     #
#                                                                         #
#             project site: http://jackwish.net/bfupdater                 #
#                                                                         #
###########################################################################

# do NOT touch below code unless you know what you are doing!
bf_update_url="http://bigfoot.178.com/wow/update.html"
bf_working_dir="/tmp/bfworking"
page_tmp="${bf_working_dir}/update.html"
bf_download_prefix="wow.bfupdate.178.com/BigFoot/Interface/3.1/Interface."
bf_tmp_pkg="${bf_working_dir}/bf_update.zip"
ext_dir="/opt/liruqi/bigfoot"
AddOns="AddOns"

function cleanup()
{
    if [ -d ${bf_working_dir} ]; then
        rm -rf ${bf_working_dir}
    fi
}

function bfupdate()
{
    echo "2. Accessing Bigfoot update site...\n"
    curl ${bf_update_url} > ${page_tmp}
    if [ $? -ne 0 ]; then
        echo "ERROR: fail to access Bigfoot update site!"
        exit 1
    fi
    iconv -c -f utf-8 -t ascii ${page_tmp} > ${page_tmp}".txt" 
    version=$(cat ${page_tmp}".txt" | cut -dV -f2 | cut -d"<" -f1)
    echo "3. Latest version is ${version}, downloading...\n"
    wget ${bf_download_prefix}${version}.zip -O ${bf_tmp_pkg} 1>/dev/null
    if [ $? -ne 0 ]; then
        echo "ERROR: fail download Bigfoot update package!"
        exit 1
    fi

    rm -rfv  ${ext_dir}"/Interface"
    echo "4. Download finished, now extracting package...\n"
    unzip ${bf_tmp_pkg} -d ${ext_dir} 1>/dev/null
    if [ $? -ne 0 ]; then
        echo "ERROR: fail extract Bigfoot package!"
        exit 1
    fi
    
    cd ${ext_dir}
    git add -A Interface  
    git commit  -m "Version ${version}"
    git push origin master
    
    echo "6. All done!\n"
}

function check_env_core()
{
    which ${1} 1>/dev/null
    if [ $? -ne 0 ]; then
        echo "ERROR: please install \"${1}\" first!"
        exit 1
    fi
}

function check_env()
{
    check_env_core curl
    check_env_core wget
    check_env_core unzip
    if [ ! -d /tmp ]; then
        echo "ERROR: no '/tmp', are you truely working on Mac???"
        exit 1
    fi
    if [ -d ${bf_working_dir} ]; then
        rm -rf ${bf_working_dir}/*
    else
        mkdir ${bf_working_dir}
    fi
    mkdir -p ${itf_path}
    echo "1. Environment check passed!\n"
}

check_env
bfupdate
cleanup
