# sql-injection Challenge 3

----------------------

Bad news. I just got a message from the hacker, and he included my admin account's password in an md5 hashed form. That only exists in my database in the user table. Is it possible he used the exploit from the last challenge to extract this?

Can you see if you can duplicate?

I'd also like to know if he can get my plaintext password from the hash. Once you extract the hash, can you see if you can convert it to plaintext?

Thanks!

-Breakthenet Game Owner

----------------------

Stuck? 
----------------------
<details> 
  <summary>Click for hint 1</summary>
   Start by gathering info. What does the [user table](https://github.com/breakthenet/sql-injection-exercises/blob/master/dbdata.sql#L1190-L1233) look like in sql?
</details>

<details> 
  <summary>Click for hint 2</summary>
   Still need more info. What is the admin's user ID? Is this exposed anywhere? Look around on the Explore page for something that could give you that info.
</details>

<details> 
  <summary>Click for hint 3</summary>
   Once you extract the password hash, "decrypt" it. True, a hash is a one way function and not actually encrypted - but as the site doesn't use salt on it's passwords, it will be trivial to reverse it if it's a common dictionary word. 
</details>



