#!/usr/bin/env python3

import socket

def until(text):
	data = b""
	while text.encode() not in data:
		data += s.recv(1)
	return data.decode()

try:
	s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
	s.connect(("hackersoc.tk", 12003))
	print(until("luck!"))
	for i in range(20):
		print(until("Produce: "), end="")
		data = until("\n").strip()
		print(data)
		print(until("profit: "), end="")
		melons = {"O":101, "0":220, "Ø":317}
		result = sum(melons.get(x, 0) for x in data.split())
		print(result)
		s.send(f"{result}".encode())
	print(until("\n"))
	print(until("\n"))
except (KeyboardInterrupt, EOFError):
	print()

s.close()
