PYTHONPATH=$PYTHONPATH:/usr/local/Cellar/python/2.7.13/Frameworks/Python.framework/Versions/2.7/lib/python2.7/site-packages:/usr/local/Cellar/python/2.7.13/Frameworks/Python.framework/Versions/2.7/lib/site-python
export PATH=$PATH:/usr/local/bin
cd /path/to/XcodeProject
/usr/local/bin/python Gmail.py
if [ -f tfrequests.sh ]; then
    cat tfrequests.sh
    export FASTLANE_PASSWORD=YourAppleDeveloperPassword
    bash -x tfrequests.sh
    rm tfrequests.sh
fi
 
