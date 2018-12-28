#!/usr/bin/env python3

import sys, socket

def until(text):
	data = b""
	while text not in data:
		data += s.recv(1)
	return data

try:
	s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
	s.connect(("hackersoc.tk", 12002))
	print(until(b"Equation: ").decode(), end="")
	data = until(b"\n").strip()
	result = eval(data.replace(b"x", b"*"))
	until(b": ")
	print(f"{data.decode()} = {result}", end="")
	s.send(b"%d\n" % result)
	while 1:
		data = until(b"\n")
		if data: sys.stdout.write(data.decode())
		if b"CTF{" in data: break
except (KeyboardInterrupt, EOFError):
	print()

s.close()
