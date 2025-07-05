-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: 127.0.0.1
-- Čas generovania: St 23.Apr 2025, 11:58
-- Verzia serveru: 10.4.32-MariaDB
-- Verzia PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `wa1`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `kvety_objednavky`
--

DROP TABLE IF EXISTS `kvety_objednavky`;
CREATE TABLE `kvety_objednavky` (
  `id` int(11) NOT NULL,
  `uid` smallint(6) NOT NULL,
  `adresa` text NOT NULL,
  `kytica` smallint(6) NOT NULL,
  `pocet` tinyint(4) NOT NULL,
  `doprava` varchar(10) NOT NULL,
  `datum` date NOT NULL,
  `cena_spolu` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `kvety_objednavky`
--

INSERT INTO `kvety_objednavky` (`id`, `uid`, `adresa`, `kytica`, `pocet`, `doprava`, `datum`, `cena_spolu`) VALUES
(1, 5, 'FMFI, Mlynská dolina, Bratislava', 3, 1, 'expres', '2025-04-21', 20),
(2, 6, 'Súmračná, Košice', 16, 1, 'kurier', '2025-04-25', 84.5),
(3, 4, 'Školská, Žilina', 21, 3, 'expres', '2025-04-30', 104.97);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `kvety_pouzivatelia`
--

DROP TABLE IF EXISTS `kvety_pouzivatelia`;
CREATE TABLE `kvety_pouzivatelia` (
  `uid` smallint(6) NOT NULL,
  `prihlasmeno` varchar(20) NOT NULL,
  `heslo` varchar(50) NOT NULL DEFAULT '',
  `meno` varchar(20) NOT NULL DEFAULT '',
  `priezvisko` varchar(30) NOT NULL DEFAULT '',
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `kvety_pouzivatelia`
--

INSERT INTO `kvety_pouzivatelia` (`uid`, `prihlasmeno`, `heslo`, `meno`, `priezvisko`, `admin`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrátor', 'systému', 1),
(2, 'uwa', '78f0f32c08873cfdba57f17c855943c0', 'predmet', 'UWA', 0),
(3, 'roman', 'b179a9ec0777eae19382c14319872e1b', 'Roman', 'Hrušecký', 1),
(4, 'anicka', '0015cc32089af63f1dfaf4fceafdfd3f', 'Anička', 'Dušička', 0),
(5, 'jozko', '256f035bd7cf72238fad007fb9199c66', 'Jožko', 'Púčik', 0),
(6, 'mrkva', 'bfd7d9c62540ed72de0f32932077bef7', 'Ferko', 'Mrkvička', 0);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `kvety_tovar`
--

DROP TABLE IF EXISTS `kvety_tovar`;
CREATE TABLE `kvety_tovar` (
  `kod` smallint(6) NOT NULL,
  `nazov` varchar(100) NOT NULL,
  `popis` text NOT NULL,
  `cena` float NOT NULL,
  `na_sklade` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `kvety_tovar`
--

INSERT INTO `kvety_tovar` (`kod`, `nazov`, `popis`, `cena`, `na_sklade`) VALUES
(1, 'Potešenie z orchideí', 'Nastal čas prekvapiť blízkych niečim novým...\r\nPripravili sme pre Vás túto radostnú kyticu zloženú zo šiestich veľkokvetých orchideí a bohatej zelene.', 26.52, 30),
(3, 'Bella', 'Kytica, ktorá pridá sviežosť do každej izby, spríjemní kanceláriu, vhodná na každú príležitosť. Kombinácia bielych a oranžových ruží.', 20, 60),
(8, 'Valencia', 'Spestrite priateľom narodeniny kombináciou oranžových ľalií a alstroemerií. Je to nezabudnuteľné vyjadrenie toho, ako si niekoho vážite.', 29.5, 50),
(9, 'Zamatová krása', 'Červená kytica (ruže, gerbery) je ten najlepší spôsob, ako ukázať úprimnú lásku bez toho, aby sa čakalo na vhodnú príležitosť.', 24, 0),
(10, 'Nežná romanca', 'Krása tejto kytice spočíva v kombinácii bielych orchideí, frézií a bieleho kvetu brassica doplnenú zelenými santínkami Yoko Ono, asparátom a trávou bergrass.', 63, 20),
(11, 'Príjemný vánok', 'Aj kytica z malého počtu kvetov môže rozjasniť deň blízkej osobe. Stačí ak jej pošlete kyticu z bordových gerbier, chryzantém ozdobenú zeleným bambusom.', 21.4, 70),
(15, 'Maslové ruže', '21 maslových ruží, ideálny darček ku každej príležitosti.', 59.72, 100),
(16, '19 bordovofialových ruží', 'Veľká okrúhla kytica uviazaná z 19 bordovofialových ruží, doplnená 5 trachéliami. Kyticu zjemňuje tráva Panicum, bohatá zeleň tvorí manžetu. (Aspidistra, bergrass, cococs, plumóza, fatsia).', 84.5, 4),
(17, 'Miešaná okrúhla kytica', 'Plná okrúhla kytica uviazaná z troch ružových ľalií, dvoch bielych chryzantém, dvoch zelených chryzantém, troch malých gerber, troch ružových gerber, piatich tmavočervených ruží, doplnená o zlatobyľ, tilandsiu a zeleň (sala, fatsia).', 60.9, 21),
(18, 'Ružové ráno', 'Máte radi voňavé kvety a túžite ich darovať niekomu, nech mu krásne voňajú? Práve Vám je určená táto kytica. Obsahuje orchidei, germini, alstromérie, hyacinty a frézie. Kytica je dozdobená ozdobnou zeleňou a doplnkami. ', 19.99, 17),
(19, 'Forever', 'Krásna kytica ladená v červených farbách. Celému aranžmánu dominuje rytierska hviezda - červený amaryllis, ktorý symbolizuje okúzľujúcu lásku obdarovanej osoby. Celá kytica je zdobená tulipánmi a minigerberami aby tak zvýraznili krásu amaryllisu a zjemnili už aj tak príjemný pocit z krásy kvetov.', 26.49, 36),
(20, 'Flamenco', 'Flamenco je nádherná letná kytica, ktorá vyvolá len tie najpríjemnejšie pocity. Každá farba navodzuje atmosféru letnej pohody plnej slnka a smiechu, ktorá nikdy nezmizne z tváre obdarovanej osoby.', 27.52, 50),
(21, 'Pierka Lásky', 'Výstižný názov pre sviežu kyticu z troch červených ruží a dvanástich bielych tulipánov. Celý aranžmán dotvárajú biele pierka, ktoré sa stali dominantným prvkom celej kompozície. Kytica pôsobí veľmi slávnostne, čo ju predurčuje aby sa stala darčekom pri rôznych oslavách, výročiach či len tak z lásky Vašim milovaným.', 34.99, 9),
(22, 'Vánok', 'Potešte svojich blízkych jednoduchou kytičkou z 9-tich farebných tulipánov.', 8.93, 100),
(23, 'Mandarinka - citrus', 'Máte radi citrusové rastliny? Práve Vám je určená nasledovná ponuka. Nenáročná citrusová rastlina, ktorá súčasne kvitne a rodí plody. Kvety príjemne voňajú a plody slúžia ako zaujímavá dekorácia. Okrem toho nie každý sa môže pochváliť, že má doma rodiacu mandarinku, ktorá je už zaštepená. Výhodou citrusových rastlín je aj fakt, že ich listy vylučujú látku, ktorá chráni človeka pred ochoreniami ako chrípka alebo nádcha. Vyžaduje svetlé miesto, pravidelnú zálievku a hnojenie každé 3 týždne.', 28.99, 100),
(24, 'Patricia', 'Jarná kytica vo sviežich farbách, ktoré nás prebúdzajú zo zimného spánku. Kvety tulipánov, tak typické pre skoré jarné mesiace sú doplnené kvetmi altromérie. Svoje miesto na kytičke nájde aj hravý motýľ, ktorý sa teší z prebúdzajúcej sa prírody.', 26.52, 80),
(25, 'Pestrý deň', 'Kytica naaranžovaná v pestrej kombinácii žltých chryzantém, karafiátov, červených ruží a bohatej zelene. ', 35.19, 50);

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `kvety_objednavky`
--
ALTER TABLE `kvety_objednavky`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `kvety_pouzivatelia`
--
ALTER TABLE `kvety_pouzivatelia`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `username` (`prihlasmeno`);

--
-- Indexy pre tabuľku `kvety_tovar`
--
ALTER TABLE `kvety_tovar`
  ADD PRIMARY KEY (`kod`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `kvety_objednavky`
--
ALTER TABLE `kvety_objednavky`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pre tabuľku `kvety_pouzivatelia`
--
ALTER TABLE `kvety_pouzivatelia`
  MODIFY `uid` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pre tabuľku `kvety_tovar`
--
ALTER TABLE `kvety_tovar`
  MODIFY `kod` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
