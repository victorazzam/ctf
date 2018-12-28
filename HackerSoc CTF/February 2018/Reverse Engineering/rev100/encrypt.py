from sys import argv

def main():
	msg = argv[1]
	pin = argv[2]
	final = ""
	for y, i in enumerate(msg):
		final += chr(ord(i) + int(pin[y % 4]))
	print final

if __name__ == "__main__":
	if len(argv) != 3 or not argv[2].isdigit() or len(argv[2]) != 4:
		exit("Usage: python encrypt.py message pin\nThe pin must be a (zero-padded) 4-digit number.")
	main()