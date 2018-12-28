public class Secure
{
	public static void main(String[] args)
	{
		int total = 1111;
		String flag = "CTF{r3verse_eng1neering_a1nt_e4sy}";
		for (String i: args)
		{
			if (i.matches("[0-9]+")) total *= Integer.valueOf(i);
		}
		if (total == 1111)
		{
			System.out.println("Usage: java Secure some_number");
			System.out.println("Make the secure combination 1337 to unlock the safe!");
			System.exit(1);
		}
		if (total == 1337) System.out.println("Congratulations! " + flag);
		else System.out.println("Sorry, wrong combination!");
	}
}
