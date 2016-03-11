#!/usr/bin/env python
from roku import Roku
retour = ''
discovered = Roku.discover()
for roku in discovered:
	retour+=roku+';'
print retour[:-1]