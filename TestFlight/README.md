这个脚本适用于在 macOS 系统下自动添加收件箱中的 TestFlight 用户。

需要把这两个文件复制到 fastlane 工作目录，并配合 crontab 使用：

```
PYTHONPATH=$PYTHONPATH:/usr/local/Cellar/python/2.7.13/Frameworks/Python.framework/Versions/2.7/lib/python2.7/site-packages:/usr/local/Cellar/python/2.7.13/Frameworks/Python.framework/Versions/2.7/lib/site-python
* * * * * bash -x /path/to/checkTF.sh >> /tmp/mume.cron.log
```

