-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 09, 2019 at 12:43 PM
-- Server version: 5.6.41
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bsdesign_collegeqiet`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_persian_ci NULL,
  `id_group` int(10) UNSIGNED NULL,
  `price` int(10) UNSIGNED NULL,
  `master` varchar(100) COLLATE utf8_persian_ci NULL,
  `time` varchar(8) COLLATE utf8_persian_ci NULL,
  `day` varchar(30) COLLATE utf8_persian_ci NULL,
  `link` text COLLATE utf8_persian_ci NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `name`, `id_group`, `price`, `master`, `time`, `day`, `link`) VALUES
(1, 'دوره ICDL درجه دو (مقدماتی)', 1, 992000, 'مهندس امید', '97/11/25', 'پنجشنبه و جمعه', 'https://college.qiet.ac.ir/%D9%81%D8%B1%D9%88%D8%B4%DA%AF%D8%A7%D9%87/%D8%AF%D9%88%D8%B1%D9%87-icdl-%D8%AF%D8%B1%D8%AC%D9%87-2-%D9%85%D9%82%D8%AF%D9%85%D8%A7%D8%AA%DB%8C/'),
(2, 'دوره ICDL درجه یک (پیشرفته)', 1, 2000000, 'مهندس امید', '97/11/25', 'پنجشنبه و جمعه', 'http://college.qiet.ac.ir/%D9%81%D8%B1%D9%88%D8%B4%DA%AF%D8%A7%D9%87/%D8%AF%D9%88%D8%B1%D9%87-icdl-%D8%AF%D8%B1%D8%AC%D9%87-%DB%8C%DA%A9-%D9%BE%DB%8C%D8%B4%D8%B1%D9%81%D8%AA%D9%87/'),
(3, 'Microsoft Project 2016(مقدماتی و پیشرفته)', 3, 2000000, 'مهندس رسولی', '97/09/01', 'سه شنبه', 'http://college.qiet.ac.ir/%D9%81%D8%B1%D9%88%D8%B4%DA%AF%D8%A7%D9%87/microsoft-project-2016-%D9%85%D9%82%D8%AF%D9%85%D8%A7%D8%AA%DB%8C-%D8%AA%D8%A7-%D9%BE%DB%8C%D8%B4%D8%B1%D9%81%D8%AA%D9%87/'),
(4, 'Microsoft Office Excel 2016(مقدماتی و پیشرفته)', 3, 2100000, 'مهندس حسن پور /مهندس هنرور', '97/08/01', 'جهارشنبه', 'https://college.qiet.ac.ir/%D9%81%D8%B1%D9%88%D8%B4%DA%AF%D8%A7%D9%87/microsoft-office-excel-2016-%D9%85%D9%82%D8%AF%D9%85%D8%A7%D8%AA%DB%8C-%D9%88-%D9%BE%DB%8C%D8%B4%D8%B1%D9%81%D8%AA%D9%87/'),
(5, 'روش اجزاء محدود در تحلیل مسائل مهندسی با ABAQUS (مقدماتی)', 4, 1900000, 'دکتر قهرمانی مقدم', '97/08/01', 'یکشنبه سه شنبه', 'https://college.qiet.ac.ir/%D9%81%D8%B1%D9%88%D8%B4%DA%AF%D8%A7%D9%87/%D8%B1%D9%88%D8%B4-%D8%A7%D8%AC%D8%B2%D8%A7%D8%A1-%D9%85%D8%AD%D8%AF%D9%88%D8%AF-%D8%AF%D8%B1-%D8%AA%D8%AD%D9%84%DB%8C%D9%84-%D9%85%D8%B3%D8%A7%D8%A6%D9%84-%D9%85%D9%87%D9%86%D8%AF%D8%B3%DB%8C-%D8%A8/'),
(6, 'روش اجزاء محدود در تحلیل مسائل مهندسی با ABAQUS (پیشرفته)', 4, 2400000, 'دکتر قهرمانی مقدم', '97/11/25', 'جهارشنبه', 'https://college.qiet.ac.ir/%D9%81%D8%B1%D9%88%D8%B4%DA%AF%D8%A7%D9%87/%D8%B1%D9%88%D8%B4-%D8%A7%D8%AC%D8%B2%D8%A7%D8%A1-%D9%85%D8%AD%D8%AF%D9%88%D8%AF-%D8%AF%D8%B1-%D8%AA%D8%AD%D9%84%DB%8C%D9%84-%D9%85%D8%B3%D8%A7%D8%A6%D9%84-%D9%85%D9%87%D9%86%D8%AF%D8%B3%DB%8C-2/'),
(7, 'مدلسازی با نرم افزار Solidworks (مقدماتی)', 4, 1400000, '', '97/08/01', 'دوشنبه', 'https://college.qiet.ac.ir/%D9%81%D8%B1%D9%88%D8%B4%DA%AF%D8%A7%D9%87/%D9%85%D8%AF%D9%84%D8%B3%D8%A7%D8%B2%DB%8C-%D8%A8%D8%A7-%D9%86%D8%B1%D9%85-%D8%A7%D9%81%D8%B2%D8%A7%D8%B1-solidworks/'),
(8, 'شبیه سازی مسائل مهندسی با نرم افزار FLUENT (مقدماتی)', 4, 1400000, 'دکتر عنبرسوز', '97/08/01', 'سه شنبه و چهارشنبه', 'https://college.qiet.ac.ir/%D9%81%D8%B1%D9%88%D8%B4%DA%AF%D8%A7%D9%87/%D8%B4%D8%A8%DB%8C%D9%87-%D8%B3%D8%A7%D8%B2%DB%8C-%D9%85%D8%B3%D8%A7%D8%A6%D9%84-%D9%85%D9%87%D9%86%D8%AF%D8%B3%DB%8C-%D8%A8%D8%A7-%D8%A7%D8%B3%D8%AA%D9%81%D8%A7%D8%AF%D9%87-%D8%A7%D8%B2-%D9%86-2/'),
(9, 'دوره آموزشی نرم افزار کامسول', 6, 1232000, 'دکتر مهدویان', '97/09/01', 'پنجشنبه و جمعه', 'https://college.qiet.ac.ir/%D9%81%D8%B1%D9%88%D8%B4%DA%AF%D8%A7%D9%87/%D8%AF%D9%88%D8%B1%D9%87-%D8%A2%D9%85%D9%88%D8%B2%D8%B4%DB%8C-%D9%86%D8%B1%D9%85-%D8%A7%D9%81%D8%B2%D8%A7%D8%B1-%DA%A9%D8%A7%D9%85%D8%B3%D9%88%D9%84/'),
(10, 'تربیت کارشناس تاسیسات مکانیکی ساختمان', 4, 9600000, 'مهندس افسری', '97/11/25', 'پنجشنبه و جمعه', 'https://college.qiet.ac.ir/%D9%81%D8%B1%D9%88%D8%B4%DA%AF%D8%A7%D9%87/%D8%B7%D8%B1%D8%A7%D8%AD%DB%8C-%D8%AA%D8%A7%D8%B3%DB%8C%D8%B3%D8%A7%D8%AA-%D9%85%DA%A9%D8%A7%D9%86%DB%8C%DA%A9%DB%8C-%D8%B3%D8%A7%D8%AE%D8%AA%D9%85%D8%A7%D9%86/');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`) VALUES
(1, 'مهندسی کامپیوتر'),
(2, 'مهندسی برق'),
(3, 'مهندسی صنایع'),
(4, 'مهندسی مکانیک'),
(5, 'مهندسی انرژی'),
(6, 'مهندسی شیمی'),
(7, 'مهندسی عمران'),
(8, 'ریاضیات و کاربردها');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `expaln` text COLLATE utf8_persian_ci NOT NULL,
  `link` varchar(1000) COLLATE utf8_persian_ci NOT NULL DEFAULT 'https://college.qiet.ac.ir/'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `expaln`, `link`) VALUES
(1, 'تخفیف دوره های مرکز آموزش عالی آزاد و مجازی دانشگاه (ویژه کارمندان)', 'مرکز آموزش های عالی آزاد و مجازی دانشگاه در نظر دارد به مناسبت افتتاح مرکز، تخفیفی برای کارکنان و بستگان آنها جهت شرکت در دوره های آموزشی،با ظرفیت محدود ارائه نماید.این دوره ها با هدف کسب تکنیک های کاربردی جهت انجام خدمات تخصصی و ارتقای مهارت های حرفه ای تمامی افراد و همچنین نیاز دانشجویان، دانش آموختگان، کارشناسان و مدیران به افزایش دانش و مهارت ها در حوزه های مرتبط با  دوره ها برنامه ریزی شده است.بر اساس این گزارش، کارکنان دانشگاه و بستگان درجه یک آنها می توانند از حداکثر ۴۰ درصد تخفیف جهت شرکت در این دوره های آموزشی بهره مند گردند.دوره ها متعاقبا اعلام می گردد.علاقه مندان جهت کسب اطلاعات بیشتر می توانند با شماره۰۵۱۴۷۰۱۷ داخلی ۲۹۳ تماس حاصل نمایند.', 'https://college.qiet.ac.ir/%D8%A7%D8%B1%D8%A7%D8%A6%D9%87-%D8%AA%D8%AE%D9%81%DB%8C%D9%81-%D9%88%DB%8C%DA%98%D9%87-%D8%AF%D9%88%D8%B1%D9%87-%D9%87%D8%A7%DB%8C-%D8%A2%D9%85%D9%88%D8%B2%D8%B4%DB%8C-%D8%AC%D9%87%D8%A7%D8%AF-%D8%AF/'),
(2, 'جشنواره بزرگ طرح افتتاحیه', 'به مناسبت آغاز فعالیت مرکز آموزش های آزاد و مجازی دانشگاه صنعتی قوچان اقدام به برگزاری “طرح افتتاحیه” کرده است که در این طرح علاقه مندان به شرکت در دوره های آموزشی این مرکز از ۲۰ درصد تخفیف برخوردار خواهند شد.\r\nعلاقمندان می توانند در گروه آموزشی مهندسی صنایع،شیمی،مکانیک،برق،عمران و ریاضی از این طرح تخفیفاتی استفاده نمایند.\r\nعلاقه مندان به حضور در این دوره ها می توانند با شماره های ۰۵۱۴۷۰۱۷ داخلی ۲۹۳ تماس حاصل فرمایند.', 'https://college.qiet.ac.ir/%D8%AC%D8%B4%D9%86%D9%88%D8%A7%D8%B1%D9%87-%D8%A8%D8%B2%D8%B1%DA%AF-%D8%B9%DB%8C%D8%AF-%D9%82%D8%B1%D8%A8%D8%A7%D9%86-%D8%AA%D8%A7-%D8%B9%DB%8C%D8%AF-%D8%BA%D8%AF%DB%8C%D8%B1/');

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `id_course` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `chat_id` int(10) UNSIGNED NOT NULL,
  `mainstate` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `groupstate` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `coursestate` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `registerstate` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `management` tinyint(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `chat_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `family` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`chat_id`, `name`, `family`, `phone`) VALUES
(92838553, 'نفس', 'عامری', '09226290160'),
(116879271, 'مسعود', 'ایمانی نیا', '09353612967');

-- ---------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `chat_id` int(10) UNSIGNED NOT NULL,
  `course_id` int(10) UNSIGNED,
  `satisfaction` int(10) UNSIGNED,
  `comment` varchar(1000) COLLATE utf8_persian_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `comments`
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`chat_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
