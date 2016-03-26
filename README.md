# sql-injection-challenge-2

A Text-Based MMORPG Game based off Mccode Lite (GPL)

Deploy to your own Heroku instance with this button below, then complete the challenge!

[![Deploy](https://www.herokucdn.com/deploy/button.png)](https://heroku.com/deploy)

Challenge:
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
   You need to inject into the Select query just like last time using a Union. [Look at the code](https://github.com/breakthenet/sql-injection-challenge-2/blob/master/cmarket.php#L109-L130) - note that after injecting into the select query, you must get past two error messages, then one of the things you just selected in your injected union gets passed as a parameter to the second query, which is an update to the user table! That's the vector.
</details>

