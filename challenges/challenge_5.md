# sql-injection Challenge 5

----------------------

I heard rumors of a new attack vector that has been found on the game engine I'm using. While I don't think it's been used against me yet, now that rumors are circling it's only a matter of time.

It is a sql injection, but this time the input is weird. I'm told that this time it's something to do with how we're recording the user's IP address.

Can you check it out and see if you can figure out how to perform the attack so we can patch our game?

Thanks!

-Breakthenet Game Owner

----------------------

Stuck? 
----------------------
<details> 
  <summary>Click for hint 1</summary>
   You may have noticed in the SQL definition of the user table, there is a field called [lastip](https://github.com/breakthenet/sql-injection-exercises/blob/master/dbdata.sql#L1199). You probably want to check where we're updating that in code.
</details>

<details> 
  <summary>Click for hint 2</summary>
  In header.php where [we update lastip](https://github.com/breakthenet/sql-injection-exercises/blob/master/header.php#L30-L33) everytime a user performs an action, you see this code:
   $ip = ($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
   
   In English, this is saying "If HTTP_X_FORWARDED_FOR is set, use that. If it's not set, use REMOTE_ADDR". Can a user manipulate either of these variables?
</details>

<details> 
  <summary>Click for hint 3</summary>
   When a user submits a web request, headers are set with that request. A user can easily modify those headers either by handcrafting code, or just by installing an add-on for their browser, such as [Modify Headers for Google Chrome](https://chrome.google.com/webstore/detail/modify-headers-for-google/innpjfdalfhpcoinfnehdnbkglpmogdi?hl=en-US).
</details>

<details> 
  <summary>Click for hint 4</summary>
   The request header you need to modify is X-Forwarded-For. This shows up as the variable $_SERVER['HTTP_X_FORWARDED_FOR'] in php.
</details>



