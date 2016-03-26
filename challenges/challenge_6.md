# sql-injection Challenge 6

----------------------

Hey, I've been talking to my co-owner, and he doesn't believe me that these vulnerabilities we've had are a big deal.

I need something from you I could give him that would show him the magnitude of the problem.

I heard of a tool called "sqlmap", and read that it can dump an entire database via a sql injection.

Can you look into that tool, and figure out how to use it with the injection in the crystal market to dump the database?

Thanks!

-Breakthenet Game Owner

----------------------

Stuck? 
----------------------
<details> 
  <summary>Click for hint 1</summary>
   You can download sqlmap [here](http://sqlmap.org/).
</details>

<details> 
  <summary>Click for hint 2</summary>
  sqlmap allows you to specify the value to test like so - in this example, I'm saying test the ID get parameter for sql injection.
  
  python sqlmap.py -u "http://mysite.com/cmarket.php?action=buy&ID=2" -p ID
</details>

<details> 
  <summary>Click for hint 3</summary>
   To maintain logged in state, you can pass in a cookie (that you obtain via logging into the game and viewing google chrome inspector) with sqlmap like so:
   
   --cookie="PHPSESSID=790i8id7q1vrqhgbbsv5qgj121"
</details>

<details> 
  <summary>Click for hint 4</summary>
   The sqlmap --dump-all parameter dumps the entire database to csv files, and will helpfully ask you if you want to reverse any password hashes found during the dump process (and then automatically do so for you).
</details>



