-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Inang: 127.0.0.1
-- Waktu pembuatan: 16 Mei 2014 pada 23.47
-- Versi Server: 5.5.32
-- Versi PHP: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Basis data: `tweetme`
--
CREATE DATABASE IF NOT EXISTS `tweetme` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `tweetme`;

DELIMITER $$
--
-- Fungsi
--
CREATE DEFINER=`root`@`localhost` FUNCTION `getTweetMsg`(idTweet INT) RETURNS varchar(160) CHARSET utf8 COLLATE utf8_unicode_ci
BEGIN
	DECLARE data VARCHAR(160);
	select tweet_msg into data from t_tweet where tweet_id = idTweet; 
	RETURN data;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_follow`
--

CREATE TABLE IF NOT EXISTS `t_follow` (
  `USER_ID_PARRENT` bigint(20) NOT NULL,
  `USER_ID_CHILD` bigint(20) NOT NULL,
  `IS_FOLLOW` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`USER_ID_PARRENT`,`USER_ID_CHILD`),
  KEY `FK_RELATIONSHIP_13` (`USER_ID_CHILD`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `t_follow`
--

INSERT INTO `t_follow` (`USER_ID_PARRENT`, `USER_ID_CHILD`, `IS_FOLLOW`) VALUES
(1398322247, 1398337420, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_notification`
--

CREATE TABLE IF NOT EXISTS `t_notification` (
  `NOTIF_ID` bigint(20) NOT NULL,
  `NOTIF_TYPE_ID` bigint(20) DEFAULT NULL,
  `NOTIF_FROM` bigint(20) NOT NULL,
  `NOTIF_TO` bigint(20) NOT NULL,
  `NOTIF_REFERENCE` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`NOTIF_FROM`,`NOTIF_ID`),
  KEY `FK_RELATIONSHIP_11` (`NOTIF_TYPE_ID`),
  KEY `FK_RELATIONSHIP_3` (`NOTIF_TO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_notification_type`
--

CREATE TABLE IF NOT EXISTS `t_notification_type` (
  `NOTIF_TYPE_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `NOTIF_NAME` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`NOTIF_TYPE_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `t_notification_type`
--

INSERT INTO `t_notification_type` (`NOTIF_TYPE_ID`, `NOTIF_NAME`) VALUES
(1, 'Reply Tweet'),
(2, 'Following');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_retweet`
--

CREATE TABLE IF NOT EXISTS `t_retweet` (
  `RETWEET_FROM` bigint(20) NOT NULL,
  `RETWEET_TO` bigint(20) NOT NULL,
  `TWEET_ID` bigint(20) DEFAULT NULL,
  `RETWEET_DATE` datetime NOT NULL,
  PRIMARY KEY (`RETWEET_FROM`),
  KEY `FK_RELATIONSHIP_10` (`TWEET_ID`),
  KEY `FK_RELATIONSHIP_9` (`RETWEET_TO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `t_retweet`
--

INSERT INTO `t_retweet` (`RETWEET_FROM`, `RETWEET_TO`, `TWEET_ID`, `RETWEET_DATE`) VALUES
(1398337420, 1398322247, 1398337551, '2014-04-25 09:36:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_role`
--

CREATE TABLE IF NOT EXISTS `t_role` (
  `ROLE_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `ROLE_NAME` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ROLE_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `t_role`
--

INSERT INTO `t_role` (`ROLE_ID`, `ROLE_NAME`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_tweet`
--

CREATE TABLE IF NOT EXISTS `t_tweet` (
  `TWEET_ID` bigint(20) NOT NULL,
  `USER_ID` bigint(20) DEFAULT NULL,
  `TWEET_MSG` varchar(160) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TWEET_DATE` datetime DEFAULT NULL,
  PRIMARY KEY (`TWEET_ID`),
  KEY `FK_RELATIONSHIP_6` (`USER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `t_tweet`
--

INSERT INTO `t_tweet` (`TWEET_ID`, `USER_ID`, `TWEET_MSG`, `TWEET_DATE`) VALUES
(1398324888, 1398322247, 'Hello tweetme !!!', '2014-04-24 02:34:48'),
(1398325224, 1398322247, '2nd tweet', '2014-04-24 02:40:24'),
(1398337551, 1398337420, 'Hey wawan', '2014-04-24 06:05:51'),
(1398420927, 1398337420, 'Apa kabar wawan hendrawan?', '2014-04-25 05:15:27'),
(1400258456, 1398322247, 'satu satu aku sayang ibu', '2014-05-16 11:40:56'),
(1400258513, 1398322247, 'dua dua aku sayang ayah', '2014-05-16 11:41:53'),
(1400258523, 1398322247, 'tiga tiga aku sayang adik kakak', '2014-05-16 11:42:03'),
(1400258537, 1398322247, 'satu dua tiga aku sayang semuanya', '2014-05-16 11:42:17'),
(1400258805, 1398322247, 'satu dua tiga empat lima enam tujuh delapan sembilan sepuluh', '2014-05-16 11:46:45'),
(1400258855, 1398322247, 'satu dua tiga empat lima enam tujuh delapan sembilan sepuluh sebelas duabelas tigabelas empatbelas limabelas enambelas tujuhbelas delapanbelas sembilanbelas', '2014-05-16 11:47:35'),
(1400263048, 1398322247, 'tengah malem dinginnya ga nahannn', '2014-05-16 12:57:28'),
(1400263072, 1398322247, 'duh aduh euy', '2014-05-16 12:57:52'),
(1400266075, 1398337420, 'wiwin dan wawan menjalin kasih dari bangku sekolah', '2014-05-16 13:47:55'),
(1400269907, 1398322247, 'udah malem, ikan bobo', '2014-05-16 14:51:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_user`
--

CREATE TABLE IF NOT EXISTS `t_user` (
  `USER_ID` bigint(20) NOT NULL,
  `ROLE_ID` bigint(20) DEFAULT NULL,
  `STATUS_ID` bigint(20) DEFAULT NULL,
  `USERNAME` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PASSWORD` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EMAIL` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `GENDER` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BIRTHDATE` date DEFAULT NULL,
  `FIRST_NAME` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `LAST_NAME` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BIO` varchar(160) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`USER_ID`),
  KEY `FK_RELATIONSHIP_4` (`ROLE_ID`),
  KEY `FK_RELATIONSHIP_5` (`STATUS_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `t_user`
--

INSERT INTO `t_user` (`USER_ID`, `ROLE_ID`, `STATUS_ID`, `USERNAME`, `PASSWORD`, `EMAIL`, `GENDER`, `BIRTHDATE`, `FIRST_NAME`, `LAST_NAME`, `BIO`) VALUES
(1398107774, 1, 1, 'admin', '5F4DCC3B5AA765D61D8327DEB882CF99', 'admin@tweetme.com', 'M', '1990-04-01', 'Admin', 'TweetMe', 'Admin of TweetMe'),
(1398322247, 2, 1, 'wawan', '0a000f688d85de79e3761dec6816b2a5', 'wawan@wawan.com', 'M', '1990-04-10', 'Wawan', 'Hendrawan', NULL),
(1398337420, 2, 1, 'wiwin', 'b6d67c9a0571394fc265616f7f47f9fb', 'wiwin@wawan.com', 'F', '1991-03-27', 'Wiwin', 'Hendrawan', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_user_status`
--

CREATE TABLE IF NOT EXISTS `t_user_status` (
  `STATUS_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `STATUS_NAME` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`STATUS_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `t_user_status`
--

INSERT INTO `t_user_status` (`STATUS_ID`, `STATUS_NAME`) VALUES
(1, 'Active'),
(2, 'Suspend');

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `t_follow`
--
ALTER TABLE `t_follow`
  ADD CONSTRAINT `FK_RELATIONSHIP_12` FOREIGN KEY (`USER_ID_PARRENT`) REFERENCES `t_user` (`USER_ID`),
  ADD CONSTRAINT `FK_RELATIONSHIP_13` FOREIGN KEY (`USER_ID_CHILD`) REFERENCES `t_user` (`USER_ID`);

--
-- Ketidakleluasaan untuk tabel `t_notification`
--
ALTER TABLE `t_notification`
  ADD CONSTRAINT `FK_RELATIONSHIP_11` FOREIGN KEY (`NOTIF_TYPE_ID`) REFERENCES `t_notification_type` (`NOTIF_TYPE_ID`),
  ADD CONSTRAINT `FK_RELATIONSHIP_2` FOREIGN KEY (`NOTIF_FROM`) REFERENCES `t_user` (`USER_ID`),
  ADD CONSTRAINT `FK_RELATIONSHIP_3` FOREIGN KEY (`NOTIF_TO`) REFERENCES `t_user` (`USER_ID`);

--
-- Ketidakleluasaan untuk tabel `t_retweet`
--
ALTER TABLE `t_retweet`
  ADD CONSTRAINT `FK_RELATIONSHIP_10` FOREIGN KEY (`TWEET_ID`) REFERENCES `t_tweet` (`TWEET_ID`),
  ADD CONSTRAINT `FK_RELATIONSHIP_8` FOREIGN KEY (`RETWEET_FROM`) REFERENCES `t_user` (`USER_ID`),
  ADD CONSTRAINT `FK_RELATIONSHIP_9` FOREIGN KEY (`RETWEET_TO`) REFERENCES `t_user` (`USER_ID`);

--
-- Ketidakleluasaan untuk tabel `t_tweet`
--
ALTER TABLE `t_tweet`
  ADD CONSTRAINT `FK_RELATIONSHIP_6` FOREIGN KEY (`USER_ID`) REFERENCES `t_user` (`USER_ID`);

--
-- Ketidakleluasaan untuk tabel `t_user`
--
ALTER TABLE `t_user`
  ADD CONSTRAINT `FK_RELATIONSHIP_4` FOREIGN KEY (`ROLE_ID`) REFERENCES `t_role` (`ROLE_ID`),
  ADD CONSTRAINT `FK_RELATIONSHIP_5` FOREIGN KEY (`STATUS_ID`) REFERENCES `t_user_status` (`STATUS_ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
