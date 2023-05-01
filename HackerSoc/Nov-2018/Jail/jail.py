#!/usr/bin/env python3

try:
	cmd = input("# ")[:50]
	cmd = "".join(x for x in cmd if x not in "fglt")
#	print(type(cmd), repr(cmd))
	try: print(eval(cmd))
	except: pass
except:
	print()
