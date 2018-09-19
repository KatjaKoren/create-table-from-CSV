using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace dnkforensic
{
    class Program
    {
        // builds a string depending on the suspects characteristics 
        static string returnDNK(string hair, string eyes, string race)
        {
            string DNK = "";

            switch (hair)
            {
                case "brown":
                    DNK = "HHHKLJ";
                    break;
                case "black":
                    DNK = "HHHKLI";
                    break;
                case "blonde":
                    DNK = "HHLH1L";
                    break;
                case "white":
                    DNK = "HHLH2L";
                    break;
            }

            switch (eyes)
            {
                case "black":
                    DNK += "140L98";
                    break;
                case "green":
                    DNK += "140A98";
                    break;
                case "brown":
                    DNK += "140A88";
                    break;
                case "blue":
                    DNK += "140L97";
                    break;
            }

            switch (race)
            {
                case "asian":
                    DNK += "1HYYYN";
                    break;
                case "hispanic":
                    DNK += "IHYYYN";
                    break;
                case "caucasian":
                    DNK += "IHYYNN";
                    break;
            }
            return DNK;
        }

        //comparing one string to the other, char by char and calculating matching percentage
        static int compareDNK(string suspect)
        {
            int match = 0;
            string DNK = "HHHKLJ140L98IHYYYN";
            int i = 0;
            foreach (char a in DNK)
            {
                if (suspect[i] == a)
                {
                    match += 1;
                }
                i++;
            }

            int percent = (match * 100) / 18;
            return percent;
        }


        static void Main(string[] args)
        {
            string JohnNovak = returnDNK("black", "green", "asian");
            string VinDiesel = returnDNK("blonde", "brown", "caucasian");
            string GuyFawkers = returnDNK("black", "brown", "hispanic");

            Console.WriteLine("DNK match percentage");
            Console.WriteLine("John Novak " + compareDNK(JohnNovak) + "%");
            Console.WriteLine("Vin Diesel " + compareDNK(VinDiesel) + "%");
            Console.WriteLine("Guy Fawkers " + compareDNK(GuyFawkers) + "%");

            Console.ReadKey();
        }
    }
}
