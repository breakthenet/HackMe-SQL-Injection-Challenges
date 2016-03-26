-- MySQL dump 10.13  Distrib 5.5.45, for Linux (x86_64)
--
-- Host: localhost    Database: heroku_1c395bf4b55596d
-- ------------------------------------------------------
-- Server version	5.5.45-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `adminlogs`
--

DROP TABLE IF EXISTS `adminlogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adminlogs` (
  `adID` int(11) NOT NULL AUTO_INCREMENT,
  `adUSER` int(11) NOT NULL DEFAULT '0',
  `adPOST` longtext NOT NULL,
  `adGET` longtext NOT NULL,
  `adTIME` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`adID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adminlogs`
--

LOCK TABLES `adminlogs` WRITE;
/*!40000 ALTER TABLE `adminlogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `adminlogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ads`
--

DROP TABLE IF EXISTS `ads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ads` (
  `adID` int(11) NOT NULL AUTO_INCREMENT,
  `adIMG` text NOT NULL,
  `adURL` text NOT NULL,
  `adVIEWS` int(11) NOT NULL DEFAULT '0',
  `adCLICKS` int(11) NOT NULL DEFAULT '0',
  `adLOGIN` varchar(255) NOT NULL DEFAULT '',
  `adPASS` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`adID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ads`
--

LOCK TABLES `ads` WRITE;
/*!40000 ALTER TABLE `ads` DISABLE KEYS */;
/*!40000 ALTER TABLE `ads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `armour`
--

DROP TABLE IF EXISTS `armour`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `armour` (
  `item_ID` int(11) NOT NULL DEFAULT '0',
  `Defence` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `armour`
--

LOCK TABLES `armour` WRITE;
/*!40000 ALTER TABLE `armour` DISABLE KEYS */;
INSERT INTO `armour` VALUES (71,1),(72,1000000),(73,2),(74,4),(75,7),(76,50),(77,10),(79,15),(80,20),(81,30),(82,40),(83,75),(84,100),(85,150),(91,40),(92,100),(93,150),(94,30),(97,400),(98,750),(71,1),(72,1000000),(73,2),(74,4),(75,7),(76,50),(77,10),(79,15),(80,20),(81,30),(82,40),(83,75),(84,100),(85,150),(91,40),(92,100),(93,150),(94,30),(97,400),(98,750);
/*!40000 ALTER TABLE `armour` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attacklogs`
--

DROP TABLE IF EXISTS `attacklogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attacklogs` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `attacker` int(11) NOT NULL DEFAULT '0',
  `attacked` int(11) NOT NULL DEFAULT '0',
  `result` enum('won','lost') NOT NULL DEFAULT 'won',
  `time` int(11) NOT NULL DEFAULT '0',
  `stole` int(11) NOT NULL DEFAULT '0',
  `attacklog` longtext NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attacklogs`
--

LOCK TABLES `attacklogs` WRITE;
/*!40000 ALTER TABLE `attacklogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `attacklogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blacklist`
--

DROP TABLE IF EXISTS `blacklist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blacklist` (
  `bl_ID` int(11) NOT NULL AUTO_INCREMENT,
  `bl_ADDER` int(11) NOT NULL DEFAULT '0',
  `bl_ADDED` int(11) NOT NULL DEFAULT '0',
  `bl_COMMENT` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`bl_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blacklist`
--

LOCK TABLES `blacklist` WRITE;
/*!40000 ALTER TABLE `blacklist` DISABLE KEYS */;
/*!40000 ALTER TABLE `blacklist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cashxferlogs`
--

DROP TABLE IF EXISTS `cashxferlogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cashxferlogs` (
  `cxID` int(11) NOT NULL AUTO_INCREMENT,
  `cxFROM` int(11) NOT NULL DEFAULT '0',
  `cxTO` int(11) NOT NULL DEFAULT '0',
  `cxAMOUNT` int(11) NOT NULL DEFAULT '0',
  `cxTIME` int(11) NOT NULL DEFAULT '0',
  `cxFROMIP` varchar(15) NOT NULL DEFAULT '127.0.0.1',
  `cxTOIP` varchar(15) NOT NULL DEFAULT '127.0.0.1',
  `cxCONTENT` longtext NOT NULL,
  PRIMARY KEY (`cxID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cashxferlogs`
--

LOCK TABLES `cashxferlogs` WRITE;
/*!40000 ALTER TABLE `cashxferlogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `cashxferlogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `challengesbeaten`
--

DROP TABLE IF EXISTS `challengesbeaten`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `challengesbeaten` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `npcid` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `challengesbeaten`
--

LOCK TABLES `challengesbeaten` WRITE;
/*!40000 ALTER TABLE `challengesbeaten` DISABLE KEYS */;
/*!40000 ALTER TABLE `challengesbeaten` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cities` (
  `cityid` int(11) NOT NULL AUTO_INCREMENT,
  `cityname` varchar(255) NOT NULL DEFAULT '',
  `citydesc` longtext NOT NULL,
  `cityminlevel` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cityid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cities`
--

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (1,'Mono Central','This city has been the home of newcomers to Mono Country for many years... it is resourceful and provides many job opportunities.',1),(2,'Country Farms','A cheap place to buy food, this is a peaceful place for pacifists but property is very expensive.',5),(3,'El Ablo','The place of the truly strong.',20),(4,'Industrial Sector','The industrial sector of Mono Central.',1),(5,'Cyber State','One for those who are masters at the game',50);
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `courses` (
  `crID` int(11) NOT NULL AUTO_INCREMENT,
  `crNAME` varchar(255) NOT NULL DEFAULT '',
  `crDESC` text NOT NULL,
  `crCOST` int(11) NOT NULL DEFAULT '0',
  `crENERGY` int(11) NOT NULL DEFAULT '0',
  `crDAYS` int(11) NOT NULL DEFAULT '0',
  `crSTR` int(11) NOT NULL DEFAULT '0',
  `crGUARD` int(11) NOT NULL DEFAULT '0',
  `crLABOUR` int(11) NOT NULL DEFAULT '0',
  `crAGIL` int(11) NOT NULL DEFAULT '0',
  `crIQ` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`crID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (1,'Computers course','Learn the basics of computers.',500,20,7,0,0,0,0,50),(2,'Intermediate Computer Course','Learn Intermediate Computer Course',1500,40,10,0,0,0,0,130),(3,'Massage therapy Course','Pretty self explainatory ^^',5000,55,21,500,0,500,0,180);
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coursesdone`
--

DROP TABLE IF EXISTS `coursesdone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coursesdone` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `courseid` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coursesdone`
--

LOCK TABLES `coursesdone` WRITE;
/*!40000 ALTER TABLE `coursesdone` DISABLE KEYS */;
/*!40000 ALTER TABLE `coursesdone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crimegroups`
--

DROP TABLE IF EXISTS `crimegroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crimegroups` (
  `cgID` int(11) NOT NULL AUTO_INCREMENT,
  `cgNAME` varchar(255) NOT NULL DEFAULT '',
  `cgORDER` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cgID`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crimegroups`
--

LOCK TABLES `crimegroups` WRITE;
/*!40000 ALTER TABLE `crimegroups` DISABLE KEYS */;
INSERT INTO `crimegroups` VALUES (1,'Search for money',1),(2,'Sell illegal CDs',2),(3,'Stealing Cars',7),(4,'Pickpocketing',3),(5,'Larceny',5),(6,'Murder',6),(7,'Deal Drugs',4),(8,'Illegal Betting',8),(9,'Abduction',9),(10,'misc.',10),(11,'IQ CRIMES',11);
/*!40000 ALTER TABLE `crimegroups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crimes`
--

DROP TABLE IF EXISTS `crimes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crimes` (
  `crimeID` int(11) NOT NULL AUTO_INCREMENT,
  `crimeNAME` varchar(255) NOT NULL DEFAULT '',
  `crimeBRAVE` int(11) NOT NULL DEFAULT '0',
  `crimePERCFORM` text NOT NULL,
  `crimeSUCCESSMUNY` int(11) NOT NULL DEFAULT '0',
  `crimeGROUP` int(11) NOT NULL DEFAULT '0',
  `crimeITEXT` text NOT NULL,
  `crimeSTEXT` text NOT NULL,
  `crimeFTEXT` text NOT NULL,
  PRIMARY KEY (`crimeID`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crimes`
--

LOCK TABLES `crimes` WRITE;
/*!40000 ALTER TABLE `crimes` DISABLE KEYS */;
INSERT INTO `crimes` VALUES (1,'Near The Council',1,'((WILL*0.8)/1)+(LEVEL/4)',10,1,'1. You head over to the council.<br />\r\n2. You start scavenging for coins.<br />','Result: You collect ${money} from the gutters!','Result: There\'s no change to be seen!'),(2,'Under a Hobo\'s Shack',1,'((WILL*0.8)/1.5)+(LEVEL/4)',20,1,'1. You head over to the shack of well-known hobo, Kent.<br />\r\n2. You creep underneath and start scavenging for money.<br />','Result: You dig up ${money}!','Result: Kent finds you and says \"What yo doin here?\". You walk off briskly.'),(3,'Music CDS',3,'((WILL*0.8)/3)+(LEVEL/4)',30,2,'1. You go down to the local market and buy some blank CDs.<br />\r\n2. You head home and burn some music onto these CDs.<br />\r\n3. You go back to the market, set up your stall, and wait for customers.<br />','Result: You sell your stock making you ${money}!','Result: No-one wants to buy your worthless garbage!'),(4,'Video CDs',3,'((WILL*0.8)/3.5)+(LEVEL/4)',34,2,'1. You go down to the local market and buy some blank CDs.<br />\r\n2. You head home and burn some videos onto these CDs.<br />\r\n3. You go back to the market, set up your stall, and wait for customers.<br />','Result: You sell your stock making you ${money}!','Result: No-one wants to buy your worthless garbage!'),(5,'Honda Civic',20,'((WILL*0.8)/20)+(LEVEL/4)',7000,3,'1. You head down to the local car yard.<br />\r\n2. You spot a Honda Civic, pretty shiny you\'d say!<br />\r\n3. You throw a rock at the window and hop in!<br />','Result: You insert your fake key and rocket off to your buds, where you give him the car and he gives you ${money} for the job!','Result: There\'s no battery, so the car won\'t run! You hop out and run away.'),(6,'Ford Falcon',25,'((WILL*0.7)/25)+(LEVEL/4)',25000,3,'1. You head down to the local car yard.<br />\r\n2. You spot a Ford Falcon, ooh it looks neat!<br />\r\n3. You throw a rock at the window, but then spy a security camera attached to the steering wheel.<br />\r\n4. You jump in, make sure you\'re out of the camera\'s view, and attempt to work it out of its socket.<br />','5. The camera pops out, you smile and throw it away.<br />\r\nResult: You insert your fake key and rocket off to your buds, where you give him the car and he gives you ${money} for the job!','Result: The camera won\'t budge. You abandon your attempt and walk home.'),(7,'Hobo',6,'((WILL*0.8)/6)+(LEVEL/4)',50,4,'1. You go down the street searching for a hobo.<br />\r\n2. You see a particularly nice-looking hobo dozing on the sidewalk.<br />\r\n3. You bend down and stick your hand into his pocket.<br />','4. You grab some notes and run away swiftly.<br />\r\n<font color=green>Result: You count up the notes, there\'s $50!</font>','<font color=brown>The hobo stirs. You dash away, not wanting to let him see you.</font>'),(8,'Teenager',6,'((WILL*0.8)/6.5)+(LEVEL/4)',100,4,'1. You go down the street searching for a teenager.<br />\r\n2. You see a kid listening to his walkman walk down the sidewalk.<br />\r\n3. You quietly go up to him and put a hand into his pocket.<br />','4. You grab a wallet and run away swiftly.<br />\r\n<font color=green>Result: You open the wallet and count up the notes, there\'s $100!</font>','<font color=brown>Result: You hit his pocket protector, you walk away slowly.</font>'),(9,'Shed',10,'((WILL*0.8)/10)+(LEVEL/4)',260,5,'1. You head to a back alley where there are lots of sheds.<br />\r\n2. You find a particularly nice-looking shed, check that there\'s no-one inside, and break open the door.<br />\r\n3. You start searching the draws.<br />','<font color=green>Result: You find $260 in a lower draw!</font>','<font color=brown>Result: You hear footsteps. You don\'t know if they are coming towards this shed, but you can\'t take the risk. You dash away with nothing in your pocket.</font>'),(10,'Motel Room',11,'((WILL*0.8)/11)+(LEVEL/4)',400,5,'1. You head over to your mates to pick up your assignment.<br />\r\n2. He gives you a piece of paper with the address on it. You hop in your car and drive there.<br />\r\n3. You throw a large rock at the window of the motel room and hop in.<br />\r\n4. You start searching for the computer your mate told you to steal for him.<br />','5. You find the computer, it looks pretty new and powerful!<br />\r\n6. You disconnect the computer from the power at the wall, disconnect the various wires, and pack it all into a cardboard box as tall as your head.<br />\r\n7. You carry the box into your car and drive back to your mate\'s.<br />\r\n<font color=green>Result: As promised, he gives you 20% of the computer\'s worth. You feel highly content with the $400 in your wallet.</font>','<font color=brown>Result: The alarm starts screeching. You get out as fast as possible and drive away.</font>'),(11,'Horse Racing',30,'((WILL*0.7)/30)+(LEVEL/5)',100000,8,'1. You set up the equipment required.<br />\r\n2. The target comes in.<br />\r\n3. You persuade him to make a bet of $100000 on a horse.<br />\r\n4. Using delayed TV, you show him the race, knowing he has picked the wrong one.<br />','<font color=green>Result: Operation Success!</font>','<font color=brown>Result: You misread the horse that won and made him bet on the winning horse! Doh!</font>'),(12,'Working Man',6,'((WILL*0.8)/6.9)+(LEVEL/4)',150,4,'1. You go down the street searching for a normal everyday working man.<br />\r\n2. You see a man briskly walking, carrying a black bag.<br />\r\n3. You quietly go up to him and reach a hand out for his bag.<br />','4. You grab it and dash off down an alleyway.<br />\r\n<font color=green>Result: You open the bag and count up the money, there\'s $150!</font>','<font color=brown>Result: You cop one in the nose as he shoos you away.</font>'),(13,'Cocaine',8,'((WILL*0.8)/8)+(LEVEL/4)',200,7,'1. You pick up a load of cocaine from your mate\'s and drive south on the M1 highway.<br />\r\n2. You see coppers chasing after you, you turn off to avoid them.<br />','3. You get off their tail and deliver the goods, collecting your fee.<br />\r\n<font color=green>Result: You feel good with $200 in your pocket!</font>','<font color=brown>Result: As they pull nearer to you you leap out of the van and run off.</font>'),(14,'Businessman',15,'((WILL*0.8)/15)+(LEVEL/4)',2000,6,'1. You arm yourself with your trusty M16 and meet your accomplice at the bus station. He gives you the job.<br />\r\n2. You drive to the target\'s mansion.<br />\r\n3. He steps out of his car, you tense up and get ready to fire.<br />','4. You blow his head off.<br />\r\n<font color=green>Result: You drive home to find $2,000 in your letterbox for the job!</font>','<font color=brown>Result: You wrongly identified the businessman, you blew a street walker\'s head off instead! Unlucky!</font>'),(15,'Casino Fraud',35,'((WILL*0.6)/35)+(LEVEL/5)',150000,8,'Casino Fraud\r\n1. You set up the equipment required.<br />\r\n2. You Start developing some fake casino Chips.<br />\r\n3. You pack the Chips into the Suit case and Head of to the local Casino.<br />\r\n4. Once inside u Bet $150000 in a single game of BlackJack.<br />','<font color=green>Result: Operation Success!\r\n\r\nYou Won $150000 and Exhanges the Real Chips for Cash</font>\r\n','<font color=brown>Result: The Dealer Spots that your Chips are Fake and calls Security\r\n\r\nNot wishing to be Caught you Run of before the Security Guards Arrive.</font>'),(16,'Drug Dealer',25,'((WILL*0.7)/25)+(LEVEL/4)',25000,6,'1. You Recieved a call for a job downtown.<br />\r\n2. You arm yourself with your trusty Sniper Rifle and head down to the Designated Area.<br />\r\n3. The Target shows up about to get into his car.<br />\r\n\r\n','4. You Take his head off clean in 1 shot.<br />\r\n<font color=green>Result: You drive home to find $25,000 in your LetterBox!</font>','4. the target steps into the car and prepares to drive off.<br />\r\n5. Yours still trying to peice your gun together but forgot what part goes where.<br />\r\n\r\n<font color=brown>Result: He Drives off safely! Bad Luck!</font>'),(17,'Vu GTS Commodore',28,'((WILL*0.7)/28)+(LEVEL/4)',80000,3,'1. You walking down a streetof a rich neighbourhood.<br />\r\n2. You see a red VU GTS Commodore with the window down.<br />\r\n3. You stop to make sure no one is looking and you open it and attempt to hot wire it.<br /> \r\n','4.You hear it crank over!<br />\r\n\r\n<font color=green>Result: Operation Success.\r\n You speed off you take it to Jimmy and he give you $80000 for it!</font>','4. You wire it wrong and blow a fuse.<br />\r\n5. The Alarm starts screeching.<br />\r\n\r\n<font color=brown>Result: you run of before somebody notices you. Bad Luck.</font>'),(18,'Millionaire\'s Daughter',45,'((WILL*0.5)/45)+(LEVEL/15)',450000,9,'1. You wait near the school where the daughter of a local millionaire attends.<br />\r\n2. They see the Target Exiting the school.<br />\r\n3. Then uou Follow the Target until you are alone.<br />','4. you put a cloth soaked with cloroform over her mouth and drag her to your Car.<br />\r\n5. You make a call to the victim\'s family, requesting $450000.<br />\r\n<font color=green>Result:Three anxious hours later, $450000 is delivered to the designated drop of point and \r\n\r\nthe exchange is made.</font>','4. Your turn around to check if there was anyone around you.<br />\r\n5. You suddenly lost sight of the target. and notice her Bodyguards around<br />\r\n\r\n<font color=brown>Result: you decides to Give up, and try again tomorrow.</font>'),(19,'Gang Ransom',50,'((WILL*0.5)/50)+(LEVEL/20)',750000,10,'1. You happened to walk by a house and noticed there someone was home alone.<br />\r\n2. You sneak in through a open window and sneaks up onto the target.<br />\r\n3. You jump out and noticed your target was Nate, doing something obsence to himself.<br />\r\n4. you happened to have a camera with you and you take a picture of him.<br />','4. Nate embarassed by the situation offers you 750k from the Gang Vault.<br />\r\n5. You agree to his conditions and take the money and leave.<br />\r\n\r\n<font color=green>Result:You walk home with $750000.</font>','4. You then Tie him up and make a phone call to Nates Gang demand Money his safety.<br />\r\n5. Nates gang decided he is not worth the ammount just laughed over the phone and hangs up<br />\r\n\r\n<font color=brown>Result: You feel agitated and decided to Infect a pineapple up his rear end.</font>'),(20,'Hijack a Train',75,'((WILL*0.1)/75)',1500000,10,'1. You step onto the train. <br />','2. Then u pull out your gun and blow the train drivers head off and take over the train.<br />\r\n3. You ring up the local authorities to request 1.5million.<br />\r\n4. They agree and pay you the money.<br />\r\n\r\n<font_color=green>Result: Operation Success, You gain 1.5million dollars.</font>','2. And noticed thats no one one it =P.<br />\r\n\r\n<font_color=brown> Result: Operation failed.</font>'),(21,'hijack Plane',95,'((WILL*0.1)/95)',3000000,10,'1. brought yourself a plane ticket.<br />\r\n2. You wait for the plane to take off. <br />\r\n','3. You take out your gun and hijack the plane.<br />\r\n4. you demand 3 million for the satefy of the passangers.<br />\r\n5. The city Mayor agrees to your demand and pays it into your swiss bank account.<br />\r\n\r\n<font_color=green>Result: operation Success. you jump out of the plane with a parachute.</font>','3. Once you are on the plane u search for your gun.<br />\r\n4. you forgot you checked it in with the baggages.<br />\r\n\r\n<font_color=brown>result: Operation failed. YOu sit down and enjoy the rest of the flight.</font>'),(22,'MC Lottery',10,'((WILL*0.01)/30)+((LEVEL*0.01)/10)',10000000,10,'1. You go and by a lottery ticket hoping to win the 10million dollar draw.<br />','2. OMFG you won.<br />\r\n3. you head down to the lottery commision and claim your 10 million dollar prize.<br />','2. When the draw comes out u find you didnt get any numbers right.<br />\r\n3. Bad luck.<br />'),(23,'Assisting Planned Robbery',10,'((IQ*0.8)/10)',250,11,'1. You sit down and plan a shoplift.<br /> \r\n2. You finish off the plan.<br /> \r\n3. Your mate comes over and you give him the plan.<br />','4. Half an hour later your m8 comes back with the goods.<br /> \r\n<font color=green> Result: He gives you half of the profit, you received $250.</font>','4. Your mate doesnt come back.<br /> <font color=brown> Result: Your mate got arrested, unlucky.</font>'),(24,'Simple Hacking',20,'((IQ*0.8)/20)',9500,11,'1. You head down to the local net cafe\' and login to the internet.<br />\r\n2. While no one is watching u look up Paypal and start inputting random email addresses.<br />','3. You happened to stumble upon a account with some decent amount of money in it.<br />\r\n4. You decide to send the cash to 10 different accounts to avoid getting caught.<br />\r\n5. You recieved $9500 in your account after spliting the money evenly.<br />\r\n<font color=green> Result: Operation Success. You head down to the Bank and Withdraw the money.</font>','3. After many attempt u could not manage to match any username and passwords.<br />\r\n4. The System logs your IP Address and locks your out of the Website.<br />\r\n\r\n<font color=brown> Result: Worried u might get caught, You turn of the computer and run out the Door. operation failed.</font>');
/*!40000 ALTER TABLE `crimes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crystalmarket`
--

DROP TABLE IF EXISTS `crystalmarket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crystalmarket` (
  `cmID` int(11) NOT NULL AUTO_INCREMENT,
  `cmQTY` int(11) NOT NULL DEFAULT '0',
  `cmADDER` int(11) NOT NULL DEFAULT '0',
  `cmPRICE` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cmID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crystalmarket`
--

LOCK TABLES `crystalmarket` WRITE;
/*!40000 ALTER TABLE `crystalmarket` DISABLE KEYS */;
INSERT INTO `crystalmarket` VALUES (1,100,2,100000);
/*!40000 ALTER TABLE `crystalmarket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dps_process`
--

DROP TABLE IF EXISTS `dps_process`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dps_process` (
  `dp_id` int(11) NOT NULL AUTO_INCREMENT,
  `dp_userid` int(11) NOT NULL DEFAULT '0',
  `dp_time` int(11) NOT NULL DEFAULT '0',
  `dp_type` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`dp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dps_process`
--

LOCK TABLES `dps_process` WRITE;
/*!40000 ALTER TABLE `dps_process` DISABLE KEYS */;
/*!40000 ALTER TABLE `dps_process` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `evID` int(11) NOT NULL AUTO_INCREMENT,
  `evUSER` int(11) NOT NULL DEFAULT '0',
  `evTIME` int(11) NOT NULL DEFAULT '0',
  `evREAD` int(11) NOT NULL DEFAULT '0',
  `evTEXT` text NOT NULL,
  PRIMARY KEY (`evID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fedjail`
--

DROP TABLE IF EXISTS `fedjail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fedjail` (
  `fed_id` int(11) NOT NULL AUTO_INCREMENT,
  `fed_userid` int(11) NOT NULL DEFAULT '0',
  `fed_days` int(11) NOT NULL DEFAULT '0',
  `fed_jailedby` int(11) NOT NULL DEFAULT '0',
  `fed_reason` text NOT NULL,
  PRIMARY KEY (`fed_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fedjail`
--

LOCK TABLES `fedjail` WRITE;
/*!40000 ALTER TABLE `fedjail` DISABLE KEYS */;
/*!40000 ALTER TABLE `fedjail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `food`
--

DROP TABLE IF EXISTS `food`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `food` (
  `item_id` int(11) NOT NULL DEFAULT '0',
  `energy` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `food`
--

LOCK TABLES `food` WRITE;
/*!40000 ALTER TABLE `food` DISABLE KEYS */;
INSERT INTO `food` VALUES (1,500),(5,3),(6,1),(15,2147483647),(21,10),(22,10),(23,25),(24,50),(25,100),(1,500),(5,3),(6,1),(15,2147483647),(21,10),(22,10),(23,25),(24,50),(25,100);
/*!40000 ALTER TABLE `food` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friendslist`
--

DROP TABLE IF EXISTS `friendslist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friendslist` (
  `fl_ID` int(11) NOT NULL AUTO_INCREMENT,
  `fl_ADDER` int(11) NOT NULL DEFAULT '0',
  `fl_ADDED` int(11) NOT NULL DEFAULT '0',
  `fl_COMMENT` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`fl_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friendslist`
--

LOCK TABLES `friendslist` WRITE;
/*!40000 ALTER TABLE `friendslist` DISABLE KEYS */;
/*!40000 ALTER TABLE `friendslist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `houses`
--

DROP TABLE IF EXISTS `houses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `houses` (
  `hID` int(11) NOT NULL AUTO_INCREMENT,
  `hNAME` varchar(255) NOT NULL DEFAULT '',
  `hPRICE` int(11) NOT NULL DEFAULT '0',
  `hWILL` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`hID`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `houses`
--

LOCK TABLES `houses` WRITE;
/*!40000 ALTER TABLE `houses` DISABLE KEYS */;
INSERT INTO `houses` VALUES (1,'Garden Shed',0,100),(2,'Apartment',12500,150),(3,'Motel Room',32000,200),(4,'Semi-Detached House',80000,250),(5,'Detached House',400000,450),(6,'Chalet',1000000,750),(7,'Mansion',15000000,1200),(8,'Penthouse',45000000,2000),(9,'Castle',125000000,3500),(11,'Luxurious Space Shuttle',375000000,7500),(10,'Small Space Shuttle',250000000,5000),(12,'Artificial Orbiting Moon',1000000000,12500),(13,'Brothel',2000000000,20000);
/*!40000 ALTER TABLE `houses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imarketaddlogs`
--

DROP TABLE IF EXISTS `imarketaddlogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imarketaddlogs` (
  `imaID` int(11) NOT NULL AUTO_INCREMENT,
  `imaITEM` int(11) NOT NULL DEFAULT '0',
  `imaPRICE` int(11) NOT NULL DEFAULT '0',
  `imaINVID` int(11) NOT NULL DEFAULT '0',
  `imaADDER` int(11) NOT NULL DEFAULT '0',
  `imaTIME` int(11) NOT NULL DEFAULT '0',
  `imaCONTENT` text NOT NULL,
  PRIMARY KEY (`imaID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imarketaddlogs`
--

LOCK TABLES `imarketaddlogs` WRITE;
/*!40000 ALTER TABLE `imarketaddlogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `imarketaddlogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imbuylogs`
--

DROP TABLE IF EXISTS `imbuylogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imbuylogs` (
  `imbID` int(11) NOT NULL AUTO_INCREMENT,
  `imbITEM` int(11) NOT NULL DEFAULT '0',
  `imbADDER` int(11) NOT NULL DEFAULT '0',
  `imbBUYER` int(11) NOT NULL DEFAULT '0',
  `imbPRICE` int(11) NOT NULL DEFAULT '0',
  `imbIMID` int(11) NOT NULL DEFAULT '0',
  `imbINVID` int(11) NOT NULL DEFAULT '0',
  `imbTIME` int(11) NOT NULL DEFAULT '0',
  `imbCONTENT` text NOT NULL,
  PRIMARY KEY (`imbID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imbuylogs`
--

LOCK TABLES `imbuylogs` WRITE;
/*!40000 ALTER TABLE `imbuylogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `imbuylogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imremovelogs`
--

DROP TABLE IF EXISTS `imremovelogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imremovelogs` (
  `imrID` int(11) NOT NULL AUTO_INCREMENT,
  `imrITEM` int(11) NOT NULL DEFAULT '0',
  `imrADDER` int(11) NOT NULL DEFAULT '0',
  `imrREMOVER` int(11) NOT NULL DEFAULT '0',
  `imrIMID` int(11) NOT NULL DEFAULT '0',
  `imrINVID` int(11) NOT NULL DEFAULT '0',
  `imrTIME` int(11) NOT NULL DEFAULT '0',
  `imrCONTENT` text NOT NULL,
  PRIMARY KEY (`imrID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imremovelogs`
--

LOCK TABLES `imremovelogs` WRITE;
/*!40000 ALTER TABLE `imremovelogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `imremovelogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory` (
  `inv_id` int(11) NOT NULL AUTO_INCREMENT,
  `inv_itemid` int(11) NOT NULL DEFAULT '0',
  `inv_userid` int(11) NOT NULL DEFAULT '0',
  `inv_qty` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`inv_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory`
--

LOCK TABLES `inventory` WRITE;
/*!40000 ALTER TABLE `inventory` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itembuylogs`
--

DROP TABLE IF EXISTS `itembuylogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `itembuylogs` (
  `ibID` int(11) NOT NULL AUTO_INCREMENT,
  `ibUSER` int(11) NOT NULL DEFAULT '0',
  `ibITEM` int(11) NOT NULL DEFAULT '0',
  `ibTOTALPRICE` int(11) NOT NULL DEFAULT '0',
  `ibQTY` int(11) NOT NULL DEFAULT '0',
  `ibTIME` int(11) NOT NULL DEFAULT '0',
  `ibCONTENT` text NOT NULL,
  PRIMARY KEY (`ibID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itembuylogs`
--

LOCK TABLES `itembuylogs` WRITE;
/*!40000 ALTER TABLE `itembuylogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `itembuylogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itemmarket`
--

DROP TABLE IF EXISTS `itemmarket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `itemmarket` (
  `imID` int(11) NOT NULL AUTO_INCREMENT,
  `imITEM` int(11) NOT NULL DEFAULT '0',
  `imADDER` int(11) NOT NULL DEFAULT '0',
  `imPRICE` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`imID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itemmarket`
--

LOCK TABLES `itemmarket` WRITE;
/*!40000 ALTER TABLE `itemmarket` DISABLE KEYS */;
INSERT INTO `itemmarket` VALUES (1,1,2,10);
INSERT INTO `itemmarket` VALUES (2,3,2,10);
INSERT INTO `itemmarket` VALUES (3,4,2,10);
INSERT INTO `itemmarket` VALUES (4,8,2,10);
INSERT INTO `itemmarket` VALUES (5,14,2,10);
INSERT INTO `itemmarket` VALUES (6,36,2,10);
INSERT INTO `itemmarket` VALUES (7,38,2,10);
INSERT INTO `itemmarket` VALUES (8,38,2,10);
INSERT INTO `itemmarket` VALUES (9,38,2,10);
INSERT INTO `itemmarket` VALUES (10,38,2,10);
INSERT INTO `itemmarket` VALUES (11,38,2,10);
INSERT INTO `itemmarket` VALUES (12,38,2,10);
INSERT INTO `itemmarket` VALUES (13,38,2,10);
/*!40000 ALTER TABLE `itemmarket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `itmid` int(11) NOT NULL AUTO_INCREMENT,
  `itmtype` int(11) NOT NULL DEFAULT '0',
  `itmname` varchar(255) NOT NULL DEFAULT '',
  `itmdesc` text NOT NULL,
  `itmbuyprice` int(11) NOT NULL DEFAULT '0',
  `itmsellprice` int(11) NOT NULL DEFAULT '0',
  `itmbuyable` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`itmid`)
) ENGINE=MyISAM AUTO_INCREMENT=109 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,1,'Sack Lunch','Deliciously filled with nutrients. Even has a slice of your favorite cake!',95000,0,1),(3,5,'Small Potion','Restores some health.',500,400,1),(4,5,'First Aid Lotion','Heals a  considerable amount of health.',1500,750,1),(5,1,'Hamburger','A scrumptious burger.',30,20,1),(6,1,'Sugar Snake','A snake covered in sugar.',10,5,1),(7,3,'Dagger','A small gold dagger.',200,100,1),(8,3,'Kitchen Knife','A knife filled with dreaded spirits of dead animals.',2500,1500,1),(9,3,'Chainsaw','Cut up your foes.',13250,10925,1),(10,4,'Pistol','A small blue pistol.',500,400,1),(11,4,'Colt','An average gun.',5000,3750,1),(12,4,'Rifle','The standard in modern weaponry.',25000,17850,1),(16,3,'Bat','A cricket bat.',75,50,1),(14,4,'Mini-Rocket Launcher','Blast your foes.',99450,78765,1),(15,1,'SuperDuper Stick','restores 100% energy',2147483647,2147483647,1),(34,5,'Will Potion','Heals will to 100%',0,0,0),(35,4,'Scout Sniper rifle','will hurt big time',99393,78353,1),(36,4,'Minigun','Sheer power',100000,75000,1),(37,3,'Diamond Dagger','Stabbing power to the max.',450000,275000,1),(38,4,'Rocket Launcher','Boom.',220000,170000,1),(39,4,'M16','...',49000,38000,1),(40,6,'Bomb Stew','Extremely rare collectors item.',0,0,0),(42,6,'\"Tit\"an Implant','Titans own way of saying hi.',0,0,0),(74,7,'Leather Jacket','Nice biker style jacket',750,500,1),(43,6,'Arsons Zippo','Arsons odd fantasy.',0,0,0),(44,3,'Demon Sword','Ultimate weapon.',0,0,0),(45,6,'Gothic Warrior-Doll','gothdavid16s favorite toy',0,0,0),(46,2,'Videogame Boy 2002','The ultimate in console action.',0,0,0),(47,6,'JaggerDoll','Won in a test of wits.',0,0,0),(49,4,'Hunting Bow','Medium range bow, silent and efficient',425,210,1),(50,3,'Foldable Chair','infamous folding chair as seen in WWF!',750,375,1),(51,3,'Nail Filer','nail accessory',300,150,1),(52,6,'MasturNATion Doll','You can sure put this doll to good use.',0,0,0),(53,6,'Toonces Bouquet','231 beautiful roses',0,0,0),(55,6,'Nahdus Rubik Cube','',0,0,0),(48,6,'Ablemits Doll','If you have it then you are so lucky.',0,0,0),(56,4,'Calibre Machine Gun','Brute power',175000,130000,1),(57,4,'benelli m1','Automatic Shotgun',33000,26500,1),(58,4,'F90 Sub Machine Gun','extremely fast short to meduim distance gun',40000,30000,1),(59,6,'Noobi Diapers','for newbies',0,0,0),(60,3,'Gladius','superior dagger',40000,30000,1),(61,3,'Katana','Japanese style sword',95000,78000,1),(62,3,'Claymore','Mysterious Medievil Sword',125000,95000,1),(63,3,'Ragnarok','mythical eastern Weapon',175000,125000,1),(64,3,'Diamond Sword','Cutting power to the max.',2000000,1700000,1),(65,4,'Battlements','Fully loaded battlements.',5000000,4000000,1),(66,6,'Conerias Duck Tape','Coneria brand duck tape',0,0,0),(67,6,'Cold Blooded Plushie','-30C toy! What more could you want!',0,0,0),(68,6,'Titanium NightVision Goggles','Increases your sight and accuracy at night',0,0,0),(69,6,'Cyber-Surfboard','Netbois !!!!',0,0,0),(70,6,'Nyuuubii Sword','Sword of the gods made for newbies',0,0,0),(71,7,'Thick Jacket','Warm clothing for the long winter',100,75,1),(73,7,'Trash Can Lid','Hard Round metal Lid',200,150,1),(75,7,'Riot Shield','standard issue shield',3000,2250,1),(77,7,'Semi-bullet proof Vest','',8750,6000,1),(78,6,'Nuclear Bomb','Can kill anyone in one blow even though the guy is lvl 100000000 and has there stats higher than everyone! ****This weapon is restricted to poor people, but still can be buyable for a high enough prize****NOTE: This weapon can kill every member in Mono Country and can gain you heaps of .exp at once! The Deadlyest weapon in the whole Country',1000000000,0,0),(79,7,'Helmet and Vest','',25000,17850,1),(80,7,'plated armour','heavy armour',75000,50000,1),(93,7,'DBS Emperor Penguin Suit','Advanced version: Agile body suit with maximum protection',3250000,2800000,1),(94,7,'Conerias DuckTaped Suit','Made with superior brand of duck tape',150000,125000,1),(83,7,'Mini-Tank','small tank almost bullet proof',750000,550000,1),(92,7,'DBS Penguin Suit','Agile body suit with maximum protection',1500000,1100000,1),(91,7,'Gothic Plate','',300000,225000,1),(86,4,'mini-Rail Gun','new Improve technology',4000000,3000000,1),(87,4,'Mounted Rail Gun','usually mounted on tanks',10000000,7500000,1),(90,4,'Arsons FlameThrower','flamethrower',150000,115000,1),(89,3,'Light Saber','',50000000,40000000,1),(95,6,'Fifty Cent Piece','A small piece of ancient Mono History.',0,0,0),(96,6,'1 Rupie','1 freaking rupie.',0,0,0),(97,7,'Plasma Shield','Battery powered arm guard',25000000,17500000,1),(98,7,'Rynax Plasma Shield','Made form a new type of power source',60000000,40000000,1),(99,4,'Plasma Gun','Fires Bolts of plasma Energy',35000000,22500000,1),(100,4,'Plasma Rifle','Full automatic energy rifle',75000000,50000000,1),(102,4,'Nuke Gun','.... this is obvious',200000000,125000000,1),(105,6,'Conerians','Awarded to helpful players. Can be redeemed for rewards.',0,0,0),(107,4,'Bio Aeroactive 350','shoots green plasma',500000000,300000000,1);
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itemselllogs`
--

DROP TABLE IF EXISTS `itemselllogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `itemselllogs` (
  `isID` int(11) NOT NULL AUTO_INCREMENT,
  `isUSER` int(11) NOT NULL DEFAULT '0',
  `isITEM` int(11) NOT NULL DEFAULT '0',
  `isTOTALPRICE` int(11) NOT NULL DEFAULT '0',
  `isQTY` int(11) NOT NULL DEFAULT '0',
  `isTIME` int(11) NOT NULL DEFAULT '0',
  `isCONTENT` text NOT NULL,
  PRIMARY KEY (`isID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itemselllogs`
--

LOCK TABLES `itemselllogs` WRITE;
/*!40000 ALTER TABLE `itemselllogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `itemselllogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itemtypes`
--

DROP TABLE IF EXISTS `itemtypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `itemtypes` (
  `itmtypeid` int(11) NOT NULL AUTO_INCREMENT,
  `itmtypename` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`itmtypeid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itemtypes`
--

LOCK TABLES `itemtypes` WRITE;
/*!40000 ALTER TABLE `itemtypes` DISABLE KEYS */;
INSERT INTO `itemtypes` VALUES (1,'Food'),(2,'Electronics'),(3,'Melee Weapon'),(4,'Gun'),(5,'Medical'),(6,'Collectible'),(7,'Armour');
/*!40000 ALTER TABLE `itemtypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itemxferlogs`
--

DROP TABLE IF EXISTS `itemxferlogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `itemxferlogs` (
  `ixID` int(11) NOT NULL AUTO_INCREMENT,
  `ixFROM` int(11) NOT NULL DEFAULT '0',
  `ixTO` int(11) NOT NULL DEFAULT '0',
  `ixITEM` int(11) NOT NULL DEFAULT '0',
  `ixQTY` int(11) NOT NULL DEFAULT '0',
  `ixTIME` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ixID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itemxferlogs`
--

LOCK TABLES `itemxferlogs` WRITE;
/*!40000 ALTER TABLE `itemxferlogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `itemxferlogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jaillogs`
--

DROP TABLE IF EXISTS `jaillogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jaillogs` (
  `jaID` int(11) NOT NULL AUTO_INCREMENT,
  `jaJAILER` int(11) NOT NULL DEFAULT '0',
  `jaJAILED` int(11) NOT NULL DEFAULT '0',
  `jaDAYS` int(11) NOT NULL DEFAULT '0',
  `jaREASON` longtext NOT NULL,
  `jaTIME` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`jaID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jaillogs`
--

LOCK TABLES `jaillogs` WRITE;
/*!40000 ALTER TABLE `jaillogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jaillogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mail`
--

DROP TABLE IF EXISTS `mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mail` (
  `mail_id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_read` int(11) NOT NULL DEFAULT '0',
  `mail_from` int(11) NOT NULL DEFAULT '0',
  `mail_to` int(11) NOT NULL DEFAULT '0',
  `mail_time` int(11) NOT NULL DEFAULT '0',
  `mail_subject` varchar(255) NOT NULL DEFAULT '',
  `mail_text` text NOT NULL,
  PRIMARY KEY (`mail_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mail`
--

LOCK TABLES `mail` WRITE;
/*!40000 ALTER TABLE `mail` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medical`
--

DROP TABLE IF EXISTS `medical`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medical` (
  `item_id` int(11) NOT NULL DEFAULT '0',
  `health` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medical`
--

LOCK TABLES `medical` WRITE;
/*!40000 ALTER TABLE `medical` DISABLE KEYS */;
INSERT INTO `medical` VALUES (2,2147483647),(3,5),(4,18),(29,100),(34,0),(2,2147483647),(3,5),(4,18),(29,100),(34,0);
/*!40000 ALTER TABLE `medical` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `papercontent`
--

DROP TABLE IF EXISTS `papercontent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `papercontent` (
  `content` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `papercontent`
--

LOCK TABLES `papercontent` WRITE;
/*!40000 ALTER TABLE `papercontent` DISABLE KEYS */;
INSERT INTO `papercontent` VALUES ('Post the latest news in your game here.'),('Post the latest news in your game here.');
/*!40000 ALTER TABLE `papercontent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preports`
--

DROP TABLE IF EXISTS `preports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `preports` (
  `prID` int(11) NOT NULL AUTO_INCREMENT,
  `prREPORTER` int(11) NOT NULL DEFAULT '0',
  `prREPORTED` int(11) NOT NULL DEFAULT '0',
  `prTEXT` longtext NOT NULL,
  PRIMARY KEY (`prID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preports`
--

LOCK TABLES `preports` WRITE;
/*!40000 ALTER TABLE `preports` DISABLE KEYS */;
/*!40000 ALTER TABLE `preports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `referals`
--

DROP TABLE IF EXISTS `referals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `referals` (
  `refID` int(11) NOT NULL AUTO_INCREMENT,
  `refREFER` int(11) NOT NULL DEFAULT '0',
  `refREFED` int(11) NOT NULL DEFAULT '0',
  `refTIME` int(11) NOT NULL DEFAULT '0',
  `refREFERIP` varchar(15) NOT NULL DEFAULT '127.0.0.1',
  `refREFEDIP` varchar(15) NOT NULL DEFAULT '127.0.0.1',
  PRIMARY KEY (`refID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `referals`
--

LOCK TABLES `referals` WRITE;
/*!40000 ALTER TABLE `referals` DISABLE KEYS */;
/*!40000 ALTER TABLE `referals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seclogs`
--

DROP TABLE IF EXISTS `seclogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seclogs` (
  `secID` int(11) NOT NULL AUTO_INCREMENT,
  `secUSER` int(11) NOT NULL DEFAULT '0',
  `secPOST` longtext NOT NULL,
  `secGET` longtext NOT NULL,
  `secTIME` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`secID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seclogs`
--

LOCK TABLES `seclogs` WRITE;
/*!40000 ALTER TABLE `seclogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `seclogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopitems`
--

DROP TABLE IF EXISTS `shopitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopitems` (
  `sitemID` int(11) NOT NULL AUTO_INCREMENT,
  `sitemSHOP` int(11) NOT NULL DEFAULT '0',
  `sitemITEMID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sitemID`)
) ENGINE=MyISAM AUTO_INCREMENT=97 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopitems`
--

LOCK TABLES `shopitems` WRITE;
/*!40000 ALTER TABLE `shopitems` DISABLE KEYS */;
INSERT INTO `shopitems` VALUES (40,9,37),(2,2,3),(14,3,16),(4,2,4),(33,7,14),(31,6,14),(7,3,7),(8,3,8),(9,3,9),(10,3,10),(11,3,11),(12,3,12),(13,3,14),(30,6,16),(29,6,12),(27,6,10),(28,6,11),(26,6,9),(24,6,7),(25,6,8),(68,3,73),(41,9,38),(39,9,36),(67,3,71),(38,8,2),(42,3,39),(43,6,39),(44,6,50),(45,3,4),(46,3,50),(47,3,49),(48,6,49),(49,6,51),(66,6,71),(51,9,35),(52,9,56),(53,6,57),(54,6,58),(55,3,60),(56,9,61),(57,9,62),(63,9,65),(59,6,35),(61,9,63),(62,9,64),(64,9,14),(65,6,60),(69,6,73),(70,3,74),(71,6,74),(72,6,77),(73,6,79),(74,6,75),(75,9,80),(76,9,81),(77,9,82),(78,4,83),(79,9,83),(80,9,84),(81,9,85),(82,9,87),(83,9,86),(84,6,88),(85,9,88),(86,10,89),(87,10,87),(89,10,97),(90,10,98),(92,10,99),(93,10,100),(94,2,40),(95,10,104),(96,9,106);
/*!40000 ALTER TABLE `shopitems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shops`
--

DROP TABLE IF EXISTS `shops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shops` (
  `shopID` int(11) NOT NULL AUTO_INCREMENT,
  `shopLOCATION` int(11) NOT NULL DEFAULT '0',
  `shopNAME` varchar(255) NOT NULL DEFAULT '',
  `shopDESCRIPTION` text NOT NULL,
  PRIMARY KEY (`shopID`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shops`
--

LOCK TABLES `shops` WRITE;
/*!40000 ALTER TABLE `shops` DISABLE KEYS */;
INSERT INTO `shops` VALUES (6,4,'Industrial Weapons','All the weapons you could need'),(2,1,'MC Pharmacy','The one-stop medi-shop.'),(3,1,'Weapons Central','The one place for all weps.'),(4,2,'Drug store','we accept weed'),(5,1,'Drug Store','we sell steriods'),(10,5,'Cyber weaponary','space age weaponary here'),(9,3,'El Ablo Weapons','Only the truly powerful weapons.');
/*!40000 ALTER TABLE `shops` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staffdetlogs`
--

DROP TABLE IF EXISTS `staffdetlogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staffdetlogs` (
  `sdID` int(11) NOT NULL AUTO_INCREMENT,
  `sdUSER` int(11) NOT NULL DEFAULT '0',
  `sdTIME` int(11) NOT NULL DEFAULT '0',
  `sdPOST` longtext NOT NULL,
  `sdGET` longtext NOT NULL,
  `sdACT` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`sdID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staffdetlogs`
--

LOCK TABLES `staffdetlogs` WRITE;
/*!40000 ALTER TABLE `staffdetlogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `staffdetlogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staffnews`
--

DROP TABLE IF EXISTS `staffnews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staffnews` (
  `snID` int(11) NOT NULL AUTO_INCREMENT,
  `snPOSTER` int(11) NOT NULL DEFAULT '0',
  `snIMPORTANCE` enum('low','medium','high') NOT NULL DEFAULT 'low',
  `snSUBJECT` varchar(255) NOT NULL DEFAULT '',
  `snTEXT` longtext NOT NULL,
  `snTIME` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`snID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staffnews`
--

LOCK TABLES `staffnews` WRITE;
/*!40000 ALTER TABLE `staffnews` DISABLE KEYS */;
/*!40000 ALTER TABLE `staffnews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staffnotelogs`
--

DROP TABLE IF EXISTS `staffnotelogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staffnotelogs` (
  `snID` int(11) NOT NULL AUTO_INCREMENT,
  `snCHANGER` int(11) NOT NULL DEFAULT '0',
  `snCHANGED` int(11) NOT NULL DEFAULT '0',
  `snTIME` int(11) NOT NULL DEFAULT '0',
  `snOLD` longtext NOT NULL,
  `snNEW` longtext NOT NULL,
  PRIMARY KEY (`snID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staffnotelogs`
--

LOCK TABLES `staffnotelogs` WRITE;
/*!40000 ALTER TABLE `staffnotelogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `staffnotelogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surrenders`
--

DROP TABLE IF EXISTS `surrenders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `surrenders` (
  `surID` int(11) NOT NULL AUTO_INCREMENT,
  `surWAR` int(11) NOT NULL DEFAULT '0',
  `surWHO` int(11) NOT NULL DEFAULT '0',
  `surTO` int(11) NOT NULL DEFAULT '0',
  `surMSG` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`surID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surrenders`
--

LOCK TABLES `surrenders` WRITE;
/*!40000 ALTER TABLE `surrenders` DISABLE KEYS */;
/*!40000 ALTER TABLE `surrenders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `txsused`
--

DROP TABLE IF EXISTS `txsused`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `txsused` (
  `txID` int(11) NOT NULL AUTO_INCREMENT,
  `txTX` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`txID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `txsused`
--

LOCK TABLES `txsused` WRITE;
/*!40000 ALTER TABLE `txsused` DISABLE KEYS */;
/*!40000 ALTER TABLE `txsused` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unjaillogs`
--

DROP TABLE IF EXISTS `unjaillogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unjaillogs` (
  `ujaID` int(11) NOT NULL AUTO_INCREMENT,
  `ujaJAILER` int(11) NOT NULL DEFAULT '0',
  `ujaJAILED` int(11) NOT NULL DEFAULT '0',
  `ujaTIME` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ujaID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unjaillogs`
--

LOCK TABLES `unjaillogs` WRITE;
/*!40000 ALTER TABLE `unjaillogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `unjaillogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '',
  `userpass` varchar(255) NOT NULL DEFAULT '',
  `level` int(11) NOT NULL DEFAULT '0',
  `exp` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `money` int(11) NOT NULL DEFAULT '0',
  `crystals` int(11) NOT NULL DEFAULT '0',
  `laston` int(11) NOT NULL DEFAULT '0',
  `lastip` varchar(255) NOT NULL DEFAULT '',
  `energy` int(11) NOT NULL DEFAULT '0',
  `will` int(11) NOT NULL DEFAULT '0',
  `maxwill` int(11) NOT NULL DEFAULT '0',
  `brave` int(11) NOT NULL DEFAULT '0',
  `maxbrave` int(11) NOT NULL DEFAULT '0',
  `maxenergy` int(11) NOT NULL DEFAULT '0',
  `hp` int(11) NOT NULL DEFAULT '0',
  `maxhp` int(11) NOT NULL DEFAULT '0',
  `lastrest_life` int(11) NOT NULL DEFAULT '0',
  `lastrest_other` int(11) NOT NULL DEFAULT '0',
  `location` int(11) NOT NULL DEFAULT '0',
  `hospital` int(11) NOT NULL DEFAULT '0',
  `jail` int(11) NOT NULL DEFAULT '0',
  `fedjail` int(11) NOT NULL DEFAULT '0',
  `user_level` int(11) NOT NULL DEFAULT '1',
  `gender` enum('Male','Female') NOT NULL DEFAULT 'Male',
  `daysold` int(11) NOT NULL DEFAULT '0',
  `signedup` int(11) NOT NULL DEFAULT '0',
  `course` int(11) NOT NULL DEFAULT '0',
  `cdays` int(11) NOT NULL DEFAULT '0',
  `donatordays` int(11) NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL DEFAULT '',
  `login_name` varchar(255) NOT NULL DEFAULT '',
  `display_pic` text NOT NULL,
  `duties` varchar(255) NOT NULL DEFAULT 'N/A',
  `bankmoney` int(11) NOT NULL DEFAULT '0',
  `cybermoney` int(11) NOT NULL DEFAULT '-1',
  `staffnotes` longtext NOT NULL,
  `mailban` int(11) NOT NULL DEFAULT '0',
  `mb_reason` varchar(255) NOT NULL DEFAULT '',
  `hospreason` varchar(255) NOT NULL DEFAULT '',
  `pass_salt` varchar(8) NOT NULL DEFAULT '',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'admin','e229dca52dbfa50c12f80f746c8d6867',1,0.0000,1000000,0,1458931688,'10.123.222.210',12,100,100,5,5,12,100,100,0,0,1,0,0,0,2,'Male',0,1458930820,0,0,0,'admin@teachthenet.com','admin','','N/A',-1,-1,'',0,'','','');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userstats`
--

DROP TABLE IF EXISTS `userstats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userstats` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `strength` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `agility` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `guard` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `labour` decimal(11,4) NOT NULL DEFAULT '0.0000',
  `IQ` decimal(11,6) NOT NULL DEFAULT '0.000000',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userstats`
--

LOCK TABLES `userstats` WRITE;
/*!40000 ALTER TABLE `userstats` DISABLE KEYS */;
INSERT INTO `userstats` VALUES (2,10.0000,10.0000,10.0000,10.0000,10.000000),(12,10.0000,10.0000,10.0000,10.0000,10.000000);
/*!40000 ALTER TABLE `userstats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `votes`
--

DROP TABLE IF EXISTS `votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `votes` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `list` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `votes`
--

LOCK TABLES `votes` WRITE;
/*!40000 ALTER TABLE `votes` DISABLE KEYS */;
/*!40000 ALTER TABLE `votes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `weapons`
--

DROP TABLE IF EXISTS `weapons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `weapons` (
  `item_id` int(11) NOT NULL DEFAULT '0',
  `damage` decimal(11,4) NOT NULL DEFAULT '0.0000'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `weapons`
--

LOCK TABLES `weapons` WRITE;
/*!40000 ALTER TABLE `weapons` DISABLE KEYS */;
INSERT INTO `weapons` VALUES (7,3.0000),(8,6.2000),(9,10.0000),(10,5.0000),(11,7.5000),(12,12.0000),(13,0.0000),(14,25.0000),(16,1.5000),(17,50.0000),(18,3450.0000),(19,0.0000),(20,1050.0000),(26,1000.0000),(27,0.0000),(28,1.0000),(30,1250.0000),(31,0.0000),(33,0.0000),(35,20.0000),(36,25.0000),(37,75.0000),(38,50.0000),(39,28.0000),(44,1.0000),(49,4.0000),(50,5.0000),(51,0.2000),(86,210.0000),(56,40.0000),(57,14.0000),(58,16.0000),(61,20.0000),(60,15.0000),(62,30.0000),(63,40.0000),(64,120.0000),(65,240.0000),(88,10.0000),(87,180.0000),(89,750.0000),(90,35.0000),(99,400.0000),(100,900.0000),(104,5000.0000),(102,1500.0000),(106,2500.0000),(107,3000.0000),(108,0.0000),(7,3.0000),(8,6.2000),(9,10.0000),(10,5.0000),(11,7.5000),(12,12.0000),(13,0.0000),(14,25.0000),(16,1.5000),(17,50.0000),(18,3450.0000),(19,0.0000),(20,1050.0000),(26,1000.0000),(27,0.0000),(28,1.0000),(30,1250.0000),(31,0.0000),(33,0.0000),(35,20.0000),(36,25.0000),(37,75.0000),(38,50.0000),(39,28.0000),(44,1.0000),(49,4.0000),(50,5.0000),(51,0.2000),(86,210.0000),(56,40.0000),(57,14.0000),(58,16.0000),(61,20.0000),(60,15.0000),(62,30.0000),(63,40.0000),(64,120.0000),(65,240.0000),(88,10.0000),(87,180.0000),(89,750.0000),(90,35.0000),(99,400.0000),(100,900.0000),(104,5000.0000),(102,1500.0000),(106,2500.0000),(107,3000.0000),(108,0.0000);
/*!40000 ALTER TABLE `weapons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `willplogs`
--

DROP TABLE IF EXISTS `willplogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `willplogs` (
  `wp_id` int(11) NOT NULL AUTO_INCREMENT,
  `wp_userid` int(11) NOT NULL DEFAULT '0',
  `wp_time` int(11) NOT NULL DEFAULT '0',
  `wp_qty` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`wp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `willplogs`
--

LOCK TABLES `willplogs` WRITE;
/*!40000 ALTER TABLE `willplogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `willplogs` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-03-25 18:51:23
