#!/usr/bin/env python
from roku import Roku
import sys
import os
import subprocess
tmppath=os.path.abspath(os.path.join(os.path.dirname(os.path.dirname(os.path.abspath(__file__))), 'tmp'))
try:
	os.stat(tmppath)
except:
	os.mkdir(tmppath)
retour = ''
roku = Roku(sys.argv[1])
listapps = roku.apps
for app in listapps:
	retour += app.name +'||'+ 'channel'+app.id+';'
	appli = roku[app.id]
	iconfile=os.path.join(tmppath, app.id+'.png')
	with open(iconfile, 'w') as f:
		f.write(appli.icon)
subprocess.call(['chmod', '-R', '777', tmppath])
print retour[:-1].encode('utf-8')
