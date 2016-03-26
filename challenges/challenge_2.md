# sql-injection Challenge 2

----------------------

Friend, you've got to help me out! 

I was looking at my database earlier today, and found an account with 9999999 crystals (which is one of the currencies in my game). It is impossible for them to get that number legitimately, that many crystals don't even exist in my game!

Can you look into it and see if you can find the hole through which this user obtained so many crystals? If you could duplicate the bug, I can fix it. A good place to start would likely be the Crystal Market on the Explore page. Feel free to explore the source code as well if that helps.

Thanks!

-Breakthenet Game Owner

----------------------



Stuck? 
----------------------
<details> 
  <summary>Click for hint 1</summary>
   [Here is the code](https://github.com/breakthenet/sql-injection-exercises/blob/master/cmarket.php#L109-L111) associated with buying crystals from the crystal market. Anything stick out to you?
</details>

<details> 
  <summary>Click for hint 2</summary>
   Always start with reconnaissance. Did you look for the sql definition of the [Crystal Market table](https://github.com/breakthenet/sql-injection-exercises/blob/master/dbdata.sql#L343-L348)?
</details>

<details> 
  <summary>Click for hint 3</summary>
   SQL Injection in PHP has some limitations - you cannot concatenate multiple queries with a semi-colon, for example. However, there are alternatives. Here's [this](http://www.mysqltutorial.org/sql-union-mysql.aspx) and [this](http://dev.mysql.com/doc/refman/5.7/en/union.html) to get you started.
</details>