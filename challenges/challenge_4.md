# sql-injection Challenge 3

----------------------

Thanks for your help on the last one friend - based on your analysis, I was able to duplicate the bug.

Before I had a chance to fix it though, I actually got a message from the hacker. His account had suddenly gone from level 1 to level 100, which should be impossible to attain in under a year.

In his message, the hacker said he used a bug in the crystal markets to update his user in the database. He told me I had 7 days to find and fix this bug, and then he would announce it publicly. 

I hate to do this to you, but can you help me again? You were successful in finding the first bug - but based on what you told me that could only select data from the database and not update it, right? Or is that not the case?

Please look into this - if the hacker could do it, I'm sure you can too. Let's close this hole before his 7 day "grace period" expires.

Thanks!

-Breakthenet Game Owner

----------------------

Stuck? 
----------------------
<details> 
  <summary>Click for hint 1</summary>
   You need to inject into the Select query just like last time using a Union. [Look at the code](https://github.com/breakthenet/sql-injection-exercises/blob/master/cmarket.php#L108-L129) - note that after injecting into the select query, you must get past two error messages, then one of the things you just selected in your injected union gets passed as a parameter to the second query, which is an update to the user table! That's the vector.
</details>

<details> 
  <summary>Click for hint 2</summary>
   Note that [all input](https://github.com/breakthenet/sql-injection-exercises/blob/master/global_func.php#L432-L450) is ran through PHP's magicquote or [addslashes](http://php.net/manual/en/function.addslashes.php) commands. These essentially just add backslashes to escape any quotes in your input. This will prevent you from using quotes in your injection - can you think of a way around that?
</details>

<details> 
  <summary>Click for hint 3</summary>
   Javascript has a handy function called [String.fromCharCode](https://developer.mozilla.org/en/docs/Web/JavaScript/Reference/Global_Objects/String/fromCharCode) that converts numbers into a string. Perhaps MySQL has functions that do something similar?
</details>



