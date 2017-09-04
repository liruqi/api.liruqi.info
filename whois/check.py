import socket
import pprint
import sys 
import os 
import argparse

parser = argparse.ArgumentParser()
parser.add_argument('--input', default='')
parser.add_argument('--output', default='output.txt')
args = parser.parse_args()

domains = []
if len(args.input) > 0:
    df = open(args.input, 'r')
    domains = df.read().split('\n')
else: 
    domains = sys.argv[1:]

cnt = 0
badnames = {}
goodnames = []
for k in domains:
    cnt += 1
    print (k, cnt, '/', len(domains))
    activePath = 'active/' + k
    expiredPath = 'expired/' + k
    try:
        if os.path.exists(activePath):
            print (k, activePath)
            goodnames.append(k)
        elif os.path.exists(expiredPath):
            print (k, expiredPath)
            continue
        else:
            info = socket.gethostbyname_ex(k)
            print k, info
            wf = open(activePath, 'w')
            wf.write(str(info))
            wf.close()
    except Exception as e:
        print k, e
        wf = open(expiredPath, 'w')
        wf.write(str(e))
        wf.close()
        badnames[k] = 1

print "\n".join(goodnames)
wf = open(args.output, 'w')
wf.write( "\n".join(goodnames) )
wf.close()
