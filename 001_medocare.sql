-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2021 at 10:55 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `001_medocare`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `week_days` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fees` double DEFAULT NULL,
  `booking_start_date` date NOT NULL DEFAULT '2021-01-07',
  `booking_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `validity` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `doctor_id`, `start_date`, `end_date`, `start_time`, `end_time`, `week_days`, `fees`, `booking_start_date`, `booking_status`, `validity`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 10, '2021-10-12', '2021-11-12', '16:00:00', '18:30:00', 'Sunday, Monday, Tuesday, Thursday', NULL, '2021-10-05', 'open', 1, '2021-01-06 20:06:10', '2021-01-09 03:03:51', NULL),
(2, 9, '2021-10-10', '2021-11-10', '14:00:00', '18:45:00', 'Sunday, Monday, Tuesday, Wednesday, Thursday', NULL, '2021-10-05', 'open', 1, '2021-01-06 20:06:10', '2021-01-09 03:03:51', NULL),
(3, 12, '2021-10-15', '2021-11-30', '17:00:00', '20:00:00', 'Sunday, Tuesday, Thursday', NULL, '2021-10-05', 'open', 1, '2021-01-06 20:06:10', '2021-01-09 03:03:51', NULL),
(4, 10, '2021-11-20', '2021-12-10', '14:00:00', '18:30:00', 'Sunday, Monday, Thursday', NULL, '2021-11-10', 'closed', 1, '2021-01-06 20:06:10', '2021-01-09 03:03:51', NULL),
(5, 6, '2021-10-12', '2021-11-30', '13:30:00', '18:30:00', 'Sunday, Monday, Wednesday, Thursday', NULL, '2021-10-06', 'open', 1, '2021-01-06 20:06:10', '2021-01-09 03:03:51', NULL),
(6, 5, '2021-10-12', '2021-11-12', '16:00:00', '20:30:00', 'Sunday, Saturday, Friday', NULL, '2021-10-05', 'open', 1, '2021-01-06 20:06:10', '2021-01-09 03:03:52', NULL),
(7, 4, '2021-10-10', '2021-11-30', '06:00:00', '10:30:00', 'Sunday, Monday, Tuesday, Saturday', NULL, '2021-10-05', 'open', 1, '2021-01-06 20:06:10', '2021-01-09 03:03:52', NULL),
(8, 4, '2021-11-10', '2021-12-30', '06:00:00', '09:00:00', 'Sunday, Monday, Tuesday, Saturday', NULL, '2021-11-06', 'open', 1, '2021-01-06 20:06:10', '2021-01-09 03:03:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `appointment_bookings`
--

CREATE TABLE `appointment_bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `appointment_id` bigint(20) UNSIGNED NOT NULL,
  `booked_date` date NOT NULL,
  `booked_time` time NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointment_bookings`
--

INSERT INTO `appointment_bookings` (`id`, `user_id`, `appointment_id`, `booked_date`, `booked_time`, `token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 7, '2021-11-02', '14:30:00', '1riP007R10aL2290ft2Y06YW023n4ZVG80', '2021-01-06 20:06:10', NULL, NULL),
(2, 2, 3, '2021-11-29', '17:00:00', '000080V7i2ME8l1Lw13B0g2h25c006EeII', '2021-01-06 20:06:10', NULL, NULL),
(3, 11, 1, '2021-11-04', '16:00:00', 'uoJz03D2gVI270j11b0006htDXT802e0Jf', '2021-01-06 20:06:10', NULL, NULL),
(4, 15, 1, '2021-11-04', '16:30:00', '1230cit026Vz0hlu487H0028vjDV1b0t0L', '2021-01-06 20:06:10', NULL, NULL),
(5, 14, 3, '2021-11-04', '17:00:00', 'aIOvA8YNwp67J2200e0i0s17k2000L2R12', '2021-01-06 20:06:10', NULL, NULL),
(6, 16, 5, '2021-11-27', '14:30:00', 'zB1oY600001Le2240K776J4Zruc07210aM', '2021-01-06 20:06:10', NULL, NULL),
(7, 13, 2, '2021-11-27', '15:00:00', '2221LnTZg20060O1xuq00wP7g0Wl07zOMk', '2021-01-06 20:06:10', NULL, NULL),
(8, 12, 2, '2021-11-27', '16:30:00', 'L2e21d060U00Fn2Up2070aj1GQb0rfVNsV', '2021-01-06 20:06:10', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `appointment_requests`
--

CREATE TABLE `appointment_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publish_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `image`, `description`, `author`, `publish_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'British Heart Foundationâ€™s Â£30 Million Big Beat Challenge.', '/storage/image/blog/British Heart Foundationâ€™s Â£30 Million Big Beat Challenge-1568709175.jpg', '<p>The British Heart Foundation (BHF) has recently launched a new single &pound;30 million research award:&nbsp;<a href=\"http://www.bhf.org.uk/bigbeatchallenge\">&lsquo;The Big Beat Challenge&rsquo;</a>. This challenge aims to fund &ldquo;the world&rsquo;s greatest minds tackling the world&rsquo;s biggest killers&rdquo;.</p>\n\n<p>The BHF is already the largest independent charity funder of cardiovascular research in the U.K, and is hoping with this substantial award to fund research that creates big change and accelerates real progress.</p>\n\n<p>This new award differs from the currently offered BHF funding streams in three main ways. Firstly, the challenge is open to international applicants and does not require a UK applicant to be part of the team. Secondly, the award is open to any domain, not just cardiovascular researchers hoping to appeal to teams utilising different skills and technologies. Thirdly, any aspect of heart or circulatory disease can be addressed by the challenges as long as there is a clear route to patient benefit.</p>\n\n<p>Applications will need to be innovative, aiming for transformative rather than incremental gains. Teams will need to be highly collaborative and multi-disciplinary with a proposal that can justify this scale of funding. The project needs to be milestone-led, with a willingness to engage with BHF supporters.</p>\n\n<p>Outline proposals can be submitted via the BHF website from December 2018. Following a review by an international advisory panel, shortlisted teams will be invited to submit full applications. Seed funding and advisory panel input will be made available at this time to further develop the proposals.</p>\n\n<p>The winner of the challenge will be announced in the Spring of 2021.</p>\n\n<p>Further details can be&nbsp;<a href=\"https://soundcloud.com/bmjpodcasts/the-big-beat-challenge-from-the-british-heart-foundation?in=bmjpodcasts/sets/heart-podcast\">heard in the Heart podcast</a>&nbsp;with Professor Nilesh Samani, Medical Director of the BHF, and also&nbsp;<a href=\"http://www.bhf.org.uk/bigbeatchallenge\">on the BHF website</a>.</p>\n\n<p>&nbsp;</p>', 'Admin', '2019-09-17 00:00:00', '2019-09-17 08:32:55', NULL, NULL),
(2, 'Drug Research And Development (JDRD).', '/storage/image/blog/Drug Research And Development (JDRD)-1568709380.jpg', '<p><strong>The Journal of Drug Research and Development (JDRD)</strong>&nbsp;presents up-to-date coverage of advanced drug systems and their innovative service to human health. Furthermore, it brings the latest developments in fast-paced areas such as new drug approvals, covering all aspects of theory, research and application of different disciplines about the effects of drugs on Preclinical and Clinical Pharmacology, drug discovery and design.</p>\n\n<p>The Editorial Committee actively pursues to be a leading source of vital knowledge by promoting excellence in the analysis of the molecules and pathways that fail or are destabilised during a dominant disorder and the interaction of these with chemical compounds and biologics. Moreover, it promotes discoveries that are anticipated to have the first impact on medication based therapeutics. Finally, it pursues the analysis and the opportune adaptation of that science to the needs of the drug discovery process.</p>\n\n<p><em><strong>The Editorial Committee</strong></em> actively pursues to be a leading source of vital knowledge by promoting excellence in the analysis of the molecules and pathways that fail or are destabilised during a dominant disorder and the interaction of these with chemical compounds and biologics. Moreover, it promotes discoveries that are anticipated to have the first impact on medication based therapeutics. Finally, it pursues the analysis and the opportune adaptation of that science to the needs of the drug discovery process.</p>', 'Admin User', '2019-09-17 00:00:00', '2019-09-17 08:36:20', NULL, NULL),
(3, 'Impact Of Climate And Climate Change On Vector-borne Diseases.', '/storage/image/blog/Impact Of Climate And Climate Change On Vector-borne Diseases.-1568720248.jpg', '<p><strong>Vector-Borne Diseases (VBDs)</strong>&nbsp;such as malaria, yellow fever, Lyme disease, plague, dengue, and leishmaniasis kill 700,000 people globally each year. Currently, the burden of VBDs is mostly found under tropical and warm climates that allow transmission all year long. This may change as our planet warms.&nbsp;<a href=\"https://idpjournal.biomedcentral.com/articles/10.1186/s40249-019-0565-1\">Florence Fouque and her colleagues</a>&nbsp;examine the impact of climate change on vector-borne diseases.</p>\n\n<p>Vector-Borne Diseases (VBDs) are so called because they are not communicable directly between humans but through arthropod vectors, and all together they account for about&nbsp;<a href=\"https://www.who.int/vector-control/publications/global-control-response/en/\">17% of infectious diseases</a>.</p>\n\n<p>Insects and ticks that represent most of the vectors of the VBDs are not capable of regulating their own body temperature, so they are linked to very specific climatic conditions for all their bionomics, as well as their geographical distribution. Consequently, the effect of the changes in the weather and climatic conditions will affect strongly and directly the vectors and the transmission patterns of the pathogens.</p>\n\n<p>Evidence of the impact of temperature and rainfall changes as well as occurrences of extreme climatic events are already available for many diseases and can be found in&nbsp;<a href=\"https://idpjournal.biomedcentral.com/articles/10.1186/s40249-019-0565-1\">our article</a>&nbsp;published in&nbsp;<a href=\"https://idpjournal.biomedcentral.com/\"><em>Infectious Diseases of Poverty</em></a>. The interventions and policies required at the international and national levels to mitigate climate change are well developed elsewhere and most countries are already engaged in specific actions to face the&nbsp;<a href=\"https://apps.who.int/gb/ebwha/pdf_files/WHA72/A72_15-en.pdf\">impact of climate change on Public Health</a>.</p>\n\n<p>However, in many situations the epidemics and deadly consequences of these changes on the health of the human populations exposed can be prevented and controlled through adequate policies and interventions and countries can develop tools for surveillance and preparedness. Further, the knowledge on the mechanisms of transmission and the impact of climate change on VBDs can also be supported through strong global and national research programs.</p>', 'Admin User', '2019-09-17 00:00:00', '2019-09-17 11:37:28', NULL, NULL),
(4, 'What Are The Signs Of A Heart Attack?', '/storage/image/blog/What Are The Signs Of A Heart Attack--1568721192.jpg', '<p><strong>Signs Of A Heart Attack May Differ In Men and Women</strong><br />\nIt&acirc;&euro;&trade;s critical to recognize that signs of a heart attack may differ in women. In addition to the typical symptom of chest pain a heart attack; women experience other atypical symptoms more frequently than men. This has led to many disparities in care over the years and there is now a strong movement to educate both healthcare providers and patients to be vigilant to this. Whereas men may more frequently experience chest pain as a sign of a heart attack, women may experience back pain, jaw pain, neck pain, nausea, shortness of breath, palpitations, indigestion, dizziness, and passing out.</p>\n\n<p><strong>Signs of a Heart Attack &acirc;&euro;&ldquo; Chest Pain That May Radiate</strong><br />\nChest pain is the most common and classic sign of a heart attack. It is often poorly localized, but is classically in the area behind the breastbone and associated with a pressure like sensation. The pain may radiate to the neck and jaw and the arms, the left arm most classically with a squeezing like sensation. These symptoms are known as angina. In stable angina these symptoms will often occur with exertion or emotional distress and go away with rest. If the symptoms last more than a few minutes then the diagnosis is certainly not considered stable angina and help should be sought.</p>\n\n<p><strong>Signs of a Heart Attack &acirc;&euro;&ldquo; Sweating</strong><br />\nThe medical term for sweating here is diaphoresis, a well-known sign of a heart attack. This occurs due to activation of a defense mechanism known as the sympathetic nervous system, a kind of fight or flight response. The sweating may occur with or without chest pain, and may occur with other non-chest pain symptoms in a heart attack such as arm pain, jaw pain, shortness of breath and such.</p>\n\n<p><strong>Signs of a Heart Attack &acirc;&euro;&ldquo; Shortness of Breath</strong><br />\nIn addition to the symptoms mentioned above, or on its own, shortness of breath is well recognized when it comes to signs of a heart attack. This occurs as a manifestation of heart failure caused by heart muscle dysfunction from the heart attack.</p>\n\n<p><strong>Signs of a Heart Attack &acirc;&euro;&ldquo; Passing out</strong><br />\nPassing out may be a sign of a heart attack, and as with other signs or symptoms can occur in isolation or with the other signs mentioned. It may be due to a number of reasons that include a dangerous heart rhythm and low blood pressure. If passing out occurs in a patient with any of the above symptoms, or in a patient with a known history of heart disease, prompt attention is needed.</p>\n\n<p><strong>Signs of a Heart Attack &acirc;&euro;&ldquo; New Palpitations</strong><br />\nAlthough palpitations on their own are not likely associated with a heart attack, those that newly occur in conjunction with chest pain, sweating and shortness of breath combined are certainly concerning. They may represent simply a fast heartbeat in response to the heart attack, or an arrhythmia directly caused by the heart attack such as ventricular tachycardia.</p>\n\n<p><strong>Signs of a Heart Attack &acirc;&euro;&ldquo; Shock</strong><br />\nThe shock referred to here is the process by where the body is unable to compensate for the affects of the heart attack such as heart failure. This generally means the output of the heart is insufficient in terms of what the body needs. Associated symptoms may be light headed and dizziness, a cool and clammy appearance, fast heart rate and low blood pressure. Shock in general would be associated with a pretty large heart attack.</p>\n\n<p>What To Do If Experiencing Signs of a Heart Attack?<br />\nThe term time is muscle is very relevant here. In the setting of a heart attack, with each minute that passes there is a chance of increasing and often irreversible heart damage. With quick action heart muscle and lives can be saved. If a heart attack is suspected then an ambulance must be called without delay. The patient needs to be taken to a hospital capable of dealing with a heart attack immediately and action taken. On immediate encounter with a healthcare provider, if a heart attack is suspected then medicine such as aspirin will be given without delay. If a STEMI heart attack is suspected then patients will often need to be taken for heart catheterization immediately, ideally within 60-120 minute of initial symptom onset.</p>\n\n<p><strong>Signs Of A Heart Attack &acirc;&euro;&ldquo; A Summary</strong><br />\nAlthough the classic presentation of a heart attack is chest pain and pressure, radiating to the neck and jaw and left arm with shortness of breath, its important to recognize many patients will have alternative signs and symptoms, especially women. These include back pain, jaw pain, neck pain, nausea, and shortness of breath, palpitations, indigestion, dizziness, and passing out as signs of a heart attack. The most important move if suspecting signs of a heart attack is to call an ambulance without delay as this may well save the life of the person experiencing the heart attack.</p>', 'Admin User', '2019-09-17 00:00:00', '2019-09-17 11:53:12', NULL, NULL),
(5, 'Eye Disease.', '/storage/image/blog/Eye Disease--1568721281.jpg', '<p><strong>Conjunctivitis (Pink Eye)</strong></p>\n\n<p>Conjunctivitis, also known as pink eye, is an infection or inflammation of the conjunctiva &acirc;&euro;&ldquo; the thin, protective membrane that covers the surface of the eyeball and inner surface of the eyelids. Caused by bacteria, viruses, allergens and other irritants like smoke and dust, pink eye is highly contagious and is usually accompanied by redness in the white of the eye and increased tearing and/or discharge.</p>\n\n<p>While many minor cases improve within two weeks, some can develop into serious corneal inflammation and threaten sight. If you suspect conjunctivitis, visit your eye care provider at Seven Lakes Eye Care for an examination and treatment.</p>\n\n<p><strong>Diabetic Eye Disease</strong></p>\n\n<p>Diabetic eye disease is a general term for a group of eye problems that can result from having type 1 or type 2 diabetes, including diabetic retinopathy, cataracts and glaucoma.</p>\n\n<p>Often there are no symptoms in the early stages of diabetic eye disease, so it is important that you don&acirc;&euro;&trade;t wait for symptoms to appear before having a comprehensive eye exam. Early detection and treatment of diabetic eye disease will dramatically reduce your chances of sustaining permanent vision loss.</p>\n\n<p>Glaucoma</p>\n\n<p>Often called &acirc;&euro;&oelig;the silent thief of sight,&acirc;&euro;&Acirc; glaucoma is an increase in the intraocular pressure of the eyes, which causes damage to the optic nerve with no signs or symptoms in the early stages of the disease. If left untreated, glaucoma can lead to a decrease in peripheral vision and eventually blindness.</p>\n\n<p>While there is no cure for glaucoma, there are medications and surgery available that can help halt further vision loss. Early detection and regular eye exams are vital to slowing the progress of the disease.</p>', 'Admin', '2019-09-17 00:00:00', '2019-09-17 11:54:41', NULL, NULL),
(6, 'Stroke: What You Need To Know.', '/storage/image/blog/Stroke- What You Need To Know--1568721545.gif', '<h2>What is a stroke?</h2>\n\n<p>A<a href=\"https://www.nhlbi.nih.gov/health-topics/stroke\">&nbsp;stroke is a medical emergency</a>. It is similar to a heart attack for the brain. It occurs when the flow of blood to the brain is interrupted, resulting in oxygen starvation to the brain cells which can no longer perform their task whether it is memory, vision or muscle control. The severity of the stroke depends on where the stroke occurs in the brain and how much damage there is. A small stroke can cause a transient and mild weakness of the right hand like in this example where a small area of blurring between the cortex and the white matter on the left side of his brain as displayed on this non-enhanced CT image.</p>\n\n<p>A large stroke can cause a permanent paralysis like in this example of a patient with an occluded right middle cerebral artery and extensive hypodense area of the right hemisphere of the brain on CT images with a resulting paralysis of the whole left side of his body.</p>\n\n<h2>How do you recognize a stroke?</h2>\n\n<p>The most common manifestations of a stroke are:</p>\n\n<ul>\n	<li>Facial drooping</li>\n	<li>Arm weakness</li>\n	<li>Slurred speech</li>\n	<li>Sudden numbness or weakness of face, arm or leg, especially on one side of the body</li>\n	<li>Sudden confusion, trouble speaking or understanding speech</li>\n	<li>Trouble seeing in one or both eyes</li>\n	<li>Trouble walking, loss of balance or dizziness</li>\n	<li>Sudden severe headache, vomiting and altered consciousness are more common in hemorrhagic or large strokes.</li>\n</ul>\n\n<h2>How do you recognize a stroke?</h2>\n\n<p>The most common manifestations of a stroke are:</p>\n\n<ul>\n	<li>Facial drooping</li>\n	<li>Arm weakness</li>\n	<li>Slurred speech</li>\n	<li>Sudden numbness or weakness of face, arm or leg, especially on one side of the body</li>\n	<li>Sudden confusion, trouble speaking or understanding speech</li>\n	<li>Trouble seeing in one or both eyes</li>\n	<li>Trouble walking, loss of balance or dizziness</li>\n	<li>Sudden severe headache, vomiting and altered consciousness are more common in hemorrhagic or large strokes.</li>\n</ul>', 'Admin User', '2019-09-17 00:00:00', '2019-09-17 11:59:05', NULL, NULL),
(7, 'Nahid Ferdous', '/storage/image/blog/Nahid Ferdous-1568721584.jpg', '<p>Wi-Fi can provide you with added coverage in places where cell networks don&#39;t always work - like basements and apartments. No roaming fees for Wi-Fi connections also means you stay connected while travelling the world.</p>\n\n<p>Wi-Fi can provide you with added coverage in places where cell networks don&#39;t always work - like basements and apartments. No roaming fees for Wi-Fi connections also means you stay connected while travelling the world.</p>\n\n<p>Wi-Fi can provide you with added coverage in places where cell networks don&#39;t always work - like basements and apartments. No roaming fees for Wi-Fi connections also means you stay connected while travelling the world.Wi-Fi can provide you with added coverage in places where cell networks don&#39;t always work - like basements and apartments. No roaming fees for Wi-Fi connections also means you stay connected while travelling the world.</p>\n\n<p>Wi-Fi can provide you with added coverage in places where cell networks don&#39;t always work - like basements and apartments. No roaming fees for Wi-Fi connections also means you stay connected while travelling the world.</p>', 'Admin User', '2019-09-17 00:00:00', '2019-09-17 13:10:40', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE `blog_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `comment` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blog_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_views`
--

CREATE TABLE `blog_views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blog_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_views`
--

INSERT INTO `blog_views` (`id`, `ip_address`, `blog_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '103.62.140.198', 6, 0, '2021-01-09 03:24:08', NULL),
(2, '103.62.140.198', 7, 0, '2021-01-14 17:25:23', NULL),
(3, '103.62.140.198', 1, 0, '2021-01-15 15:43:31', NULL),
(4, '103.62.140.198', 3, 0, '2021-01-20 16:42:47', NULL),
(5, '77.111.246.81', 7, 0, '2021-01-20 16:43:53', NULL),
(6, '103.62.140.198', 5, 0, '2021-01-26 19:04:33', NULL),
(7, '103.62.140.197', 6, 0, '2021-02-25 01:59:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `consultations`
--

CREATE TABLE `consultations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `appointment_booking_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `consultation_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'regular',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consultations`
--

INSERT INTO `consultations` (`id`, `user_id`, `doctor_id`, `appointment_booking_id`, `status`, `consultation_type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 4, 1, 'session end', 'regular', '2021-01-06 20:06:10', '2021-02-28 20:09:47', NULL),
(2, 2, 12, 2, 'session end', 'regular', '2021-01-06 20:06:10', '2021-02-28 03:40:24', NULL),
(3, 11, 10, 3, 'session end', 'regular', '2021-01-06 20:06:10', '2021-02-28 03:40:25', NULL),
(4, 15, 10, 4, 'session end', 'regular', '2021-01-06 20:06:10', '2021-02-28 03:40:25', NULL),
(5, 14, 12, 5, 'session end', 'regular', '2021-01-06 20:06:10', '2021-02-28 03:40:25', NULL),
(6, 16, 6, 6, 'session end', 'regular', '2021-01-06 20:06:10', '2021-02-28 20:09:47', NULL),
(7, 13, 9, 7, 'in progress', 'regular', '2021-01-06 20:06:10', '2021-02-28 20:06:00', NULL),
(8, 12, 9, 8, 'session end', 'regular', '2021-01-06 20:06:10', '2021-02-28 03:40:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT 0,
  `replied` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `name`, `email`, `phone`, `message`, `user_id`, `seen`, `replied`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Nahid', 'nahidferdous2@gmail.com', '01857823870', 'Hi there i am having problem in figuring out how to book an appointment. I need help regarding this.', 2, 0, 0, '2021-01-06 20:06:10', NULL, NULL),
(2, 'Nahid', 'nahidferdous2@gmail.com', '01857823870', 'This is a test message.', NULL, 0, 0, '2021-01-06 20:06:10', NULL, '2021-01-06 20:06:10'),
(3, 'Code Knight', 'codeknight69@gmail.com', '01857823870', 'This is a test message from CodeKnight.', NULL, 0, 0, '2021-01-06 20:06:10', NULL, NULL),
(4, 'nahid nfr', 'nahidferdous240@gmail.com', '01857823870', 'This is a test message from nahid nfr.', NULL, 1, 0, '2021-01-06 20:06:10', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `consultation_id` bigint(20) UNSIGNED NOT NULL,
  `conversation_text` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conversation_file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_name`, `icon`, `details`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Medicine', 'Medicine.png', 'Medicine is the science and practice of establishing the diagnosis, prognosis, treatment, and prevention of disease. Medicine encompasses a variety of health care practices evolved to maintain and restore health by the prevention and treatment of illness. Contemporary medicine applies biomedical sciences, biomedical research, genetics, and medical technology to diagnose, treat, and prevent injury and disease, typically through pharmaceuticals or surgery, but also through therapies as diverse as psychotherapy, external splints and traction, medical devices, biologics, and ionizing radiation, amongst others.', '2021-01-06 20:06:10', NULL, NULL),
(2, 'Dental', 'Dental.png', 'Dentistry, also known as Dental and Oral Medicine, is a branch of medicine that consists of the study, diagnosis, prevention, and treatment of diseases, disorders, and conditions of the oral cavity, commonly in the dentition but also the oral mucosa, and of adjacent and related structures and tissues, particularly in the maxillofacial (jaw and facial) area.[1] Although primarily associated with teeth among the general public, the field of dentistry or dental medicine is not limited to teeth but includes other aspects of the craniofacial complex including the temporomandibular joint and other supporting, muscular, lymphatic, nervous, vascular, and anatomical structures.', '2021-01-06 20:06:10', NULL, NULL),
(3, 'Cardiology', 'Cardiology.png', 'Cardiology is a branch of medicine that deals with the disorders of the heart as well as some parts of the circulatory system. The field includes medical diagnosis and treatment of congenital heart defects, coronary artery disease, heart failure, valvular heart disease and electrophysiology. Physicians who specialize in this field of medicine are called cardiologists, a specialty of internal medicine. Pediatric cardiologists are pediatricians who specialize in cardiology. Physicians who specialize in cardiac surgery are called cardiothoracic surgeons or cardiac surgeons, a specialty of general surgery.', '2021-01-06 20:06:10', NULL, NULL),
(4, 'Neurology', 'Neurology.png', 'Neurology  is a branch of medicine dealing with disorders of the nervous system. Neurology deals with the diagnosis and treatment of all categories of conditions and disease involving the central and peripheral nervous systems (and their subdivisions, the autonomic and somatic nervous systems), including their coverings, blood vessels, and all effector tissue, such as muscle. Neurological practice relies heavily on the field of neuroscience, the scientific study of the nervous system.', '2021-01-06 20:06:10', NULL, NULL),
(5, 'Orthopedic', 'Orthopedic.png', 'Orthopedics is a medical specialty that focuses on the diagnosis, correction, prevention, and treatment of patients with skeletal deformities - disorders of the bones, joints, muscles, ligaments, tendons, nerves and skin. These elements make up the musculoskeletal system.\n\nYour body\'s musculoskeletal system is a complex system of bones, joints, ligaments, tendons, muscles and nerves and allows you to move, work and be active. Once devoted to the care of children with spine and limb deformities, orthopedics now cares for patients of all ages, from newborns with clubfeet, to young athletes requiring arthroscopic surgery, to older people with arthritis.\n\nThe physicians who specialize in this area are called orthopedic surgeons or orthopedists.', '2021-01-06 20:06:10', NULL, NULL),
(6, 'Gastroenterology', 'Gastroenterology.png', 'Gastroenterology[1] is the branch of medicine focused on the digestive system and its disorders.\n\nDiseases affecting the gastrointestinal tract, which include the organs from mouth into anus, along the alimentary canal, are the focus of this speciality. Physicians practicing in this field are called gastroenterologists. They have usually completed about eight years of pre-medical and medical education, a year-long internship (if this is not a part of the residency), three years of an internal medicine residency, and two to three years in the gastroenterology fellowship. Gastroenterologists perform a number of diagnostic and therapeutic procedures including colonoscopy, endoscopy, endoscopic retrograde cholangiopancreatography (ERCP), endoscopic ultrasound and liver biopsy. Some gastroenterology trainees will complete a \"fourth-year\" (although this is often their seventh year of graduate medical education) in transplant hepatology, advanced endoscopy, inflammatory bowel disease, motility or other topics.', '2021-01-06 20:06:10', NULL, NULL),
(7, 'Skin', 'Skin.png', 'Dermatology is the branch of medicine dealing with the skin, nails, hair ( functions & structures ) and its diseases. It is a specialty with both medical and surgical aspects. A dermatologist is specialist doctor that manages diseases, in the widest sense, and some cosmetic problems of the skin, hair and nails.', '2021-01-06 20:06:10', NULL, NULL),
(8, 'Eye', 'Eye.png', 'Ophthalmology is a branch of medicine and surgery which deals with the diagnosis and treatment of eye disorders. An ophthalmologist is a specialist in ophthalmology. The credentials include a degree in medicine, followed by additional four to five years of ophthalmology residency training. Ophthalmology residency training programs may require a one year pre-residency training in internal medicine, pediatrics, or general surgery. Additional specialty training (or fellowship) may be sought in a particular aspect of eye pathology. Ophthalmologists are allowed to use medications to treat eye diseases, implement laser therapy, and perform surgery when needed. Ophthalmologists may participate in academic research on the diagnosis and treatment for eye disorders.', '2021-01-06 20:06:10', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `nationality` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_place_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_place_document` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `education` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `experience` int(11) NOT NULL,
  `working_days` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fees` double DEFAULT NULL,
  `about` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_sent` tinyint(1) NOT NULL DEFAULT 0,
  `email_verification_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `user_id`, `department_id`, `nationality`, `work_place_name`, `work_place_document`, `education`, `experience`, `working_days`, `fees`, `about`, `email_sent`, `email_verification_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 4, 2, 'Bangladeshi', 'Bangabandhu Sheikh Mujib Medical University ( BSMMU ).', '/storage/user_data/doctor/document/mizanur_rahman.pdf', 'MBBS, PhD, FACP', 4, 'Sunday, Monday, Tuesday, Thursday', NULL, 'I am a doctor from dhaka city. I have over 2 years of experience i work in a popular medical hospital in dhaka city.', 1, NULL, '2021-01-06 20:06:10', NULL, NULL),
(2, 5, 1, 'Bangladeshi', 'Dhaka Medical College & Hospital.', '/storage/user_data/doctor/document/Mahid_Hasan.pdf', 'MBBS, MD', 4, 'Sunday, Monday, Tuesday, Thursday', NULL, 'I am a doctor from dhaka city. I have over 2 years of experience i work in a popular medical hospital in dhaka city.', 1, NULL, '2021-01-06 20:06:10', NULL, NULL),
(3, 6, 1, 'Bangladeshi', 'Armed Forces Medical College, Dhaka.', '/storage/user_data/doctor/document/abdul_azim.pdf', 'MBBS', 5, 'Sunday, Monday, Tuesday', NULL, 'I am a doctor from dhaka city. I have over 2 years of experience i work in a popular medical hospital in dhaka city.', 1, 'Ss5F6cT3DymfJ2CzgcFarUce56WXz4Cl', '2021-01-06 20:06:10', NULL, NULL),
(4, 8, 4, 'Bangladeshi', 'Dhaka medical college and hospital.', '/storage/user_data/doctor/document/farjana_alom.pdf', 'MBBS, MCPS, MD', 6, 'Sunday, Monday, Tuesday', NULL, 'I am a doctor from dhaka city. I have over 2 years of experience i work in a popular medical hospital in dhaka city.', 1, NULL, '2021-01-06 20:06:10', NULL, NULL),
(5, 9, 7, 'Bangladeshi', 'Bangabandhu Sheikh Mujib Medical University.', '/storage/user_data/doctor/document/nasir.pdf', 'MBBS, MD', 2, 'Sunday, Monday, Tuesday', NULL, 'I am a doctor from dhaka city. I have over 2 years of experience i work in a popular medical hospital in dhaka city.', 0, NULL, '2021-01-06 20:06:10', NULL, NULL),
(6, 10, 3, 'Bangladeshi', 'Bangladesh Medical College & Hospital, Dhaka, Bangladesh.', '/storage/user_data/doctor/document/rakibhosain.pdf', 'MBBS, FCPS', 2, 'Sunday, Wednesday, Tuesday', NULL, 'I am a doctor from dhaka city. I have over 2 years of experience i work in a popular medical hospital in dhaka city.', 1, NULL, '2021-01-06 20:06:10', NULL, NULL),
(7, 17, 5, 'Bangladeshi', 'Dhaka medical college and hospital.', '/storage/user_data/doctor/document/rakibhosain.pdf', 'MBBS', 2, 'Sunday, Wednesday, Tuesday', NULL, 'I am a doctor from dhaka city. I have over 2 years of experience i work in a popular medical hospital in dhaka city.', 1, NULL, '2021-01-06 20:06:10', NULL, NULL),
(8, 18, 6, 'Bangladeshi', 'Health & Hope Hospital Ltd.', '/storage/user_data/doctor/document/rakibhosain.pdf', 'MBBS, FCPS', 2, 'Sunday, Wednesday, Tuesday', NULL, 'I am a doctor from dhaka city. I have over 2 years of experience i work in a popular medical hospital in dhaka city.', 1, NULL, '2021-01-06 20:06:10', NULL, NULL),
(9, 19, 7, 'Bangladeshi', 'Popular Diagnostic Centre Ltd.', '/storage/user_data/doctor/document/rakibhosain.pdf', 'MBBS, FCPS', 2, 'Sunday, Wednesday, Tuesday, Saturday', NULL, 'I am a doctor from dhaka city. I have over 2 years of experience i work in a popular medical hospital in dhaka city.', 1, NULL, '2021-01-06 20:06:10', NULL, NULL),
(10, 20, 8, 'Bangladeshi', 'Dhaka National Medical College & Hospital.', '/storage/user_data/doctor/document/rakibhosain.pdf', 'MBBS', 2, 'Wednesday, Tuesday, Thursday', NULL, 'I am a doctor from dhaka city. I have over 2 years of experience i work in a popular medical hospital in dhaka city.', 1, NULL, '2021-01-06 20:06:10', NULL, NULL),
(11, 21, 8, 'Bangladeshi', 'Holy Family Red Crescent Hospital.', '/storage/user_data/doctor/document/rakibhosain.pdf', 'MBBS', 2, 'Sunday, Wednesday, Tuesday', NULL, 'I am a doctor from dhaka city. I have over 2 years of experience i work in a popular medical hospital in dhaka city.', 1, NULL, '2021-01-06 20:06:10', NULL, NULL),
(12, 22, 5, 'Bangladeshi', 'Shaheed Suhrawardy Medical College and Hospital.', '/storage/user_data/doctor/document/rakibhosain.pdf', 'MBBS', 2, 'Sunday, Wednesday, Tuesday, Friday', NULL, 'I am a doctor from dhaka city. I have over 2 years of experience i work in a popular medical hospital in dhaka city.', 1, NULL, '2021-01-06 20:06:10', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `doctor_ratings`
--

CREATE TABLE `doctor_ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `rating_value` double(8,2) NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comments` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctor_ratings`
--

INSERT INTO `doctor_ratings` (`id`, `doctor_id`, `patient_id`, `rating_value`, `title`, `comments`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 4, 1, 2.00, 'Rating', 'He is a good doctor, he is very humble and cooperative.', '2021-01-06 20:06:10', NULL, NULL),
(2, 4, 3, 4.00, 'Rating', 'He is a good doctor.', '2021-01-06 20:06:10', NULL, NULL),
(3, 4, 2, 3.00, 'Rating', 'Please try to publish prescriptions and reports quickly.', '2021-01-06 20:06:10', NULL, NULL),
(4, 2, 1, 5.00, 'Rating', 'He is very humble and cooperative. Best doctor in this community.', '2021-01-06 20:06:10', NULL, NULL),
(5, 2, 3, 2.00, 'Rating', 'Communication skill not good.', '2021-01-06 20:06:10', NULL, NULL),
(6, 2, 2, 3.00, 'Rating', 'Please improve your communication skills.', '2021-01-06 20:06:10', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `emergency_conversations`
--

CREATE TABLE `emergency_conversations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `appointment_request_id` bigint(20) UNSIGNED NOT NULL,
  `conversation_text` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conversation_file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(429, '2014_10_12_000000_create_users_table', 1),
(430, '2014_10_12_100000_create_password_resets_table', 1),
(431, '2019_08_19_000000_create_failed_jobs_table', 1),
(432, '2019_09_06_103430_create_roles_table', 1),
(433, '2019_09_06_103726_create_role_user_table', 1),
(434, '2019_09_12_084253_create_patients_table', 1),
(435, '2019_09_12_084313_create_departments_table', 1),
(436, '2019_09_12_084314_create_doctors_table', 1),
(437, '2019_09_12_093639_create_doctor_ratings_table', 1),
(438, '2019_09_12_093725_create_contact_us_table', 1),
(439, '2019_09_12_093857_create_blogs_table', 1),
(440, '2019_09_12_093906_create_blog_comments_table', 1),
(441, '2019_09_12_093915_create_blog_views_table', 1),
(442, '2019_09_12_094055_create_appointments_table', 1),
(443, '2019_09_12_094142_create_appointment_bookings_table', 1),
(444, '2019_09_12_094156_create_appointment_requests_table', 1),
(445, '2019_09_12_095758_create_patient_reports_table', 1),
(446, '2019_09_12_095813_create_consultations_table', 1),
(447, '2019_09_12_095829_create_conversations_table', 1),
(448, '2019_09_12_100000_create_notification_types_table', 1),
(449, '2019_09_12_100042_create_notifications_table', 1),
(450, '2019_10_27_215728_create_emergency_conversations_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `notification_type_id` bigint(20) NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_types`
--

CREATE TABLE `notification_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, '2021-01-06 20:06:10', NULL, NULL),
(2, 3, '2021-01-06 20:06:10', NULL, NULL),
(3, 7, '2021-01-06 20:06:10', NULL, NULL),
(4, 11, '2021-01-06 20:06:10', NULL, NULL),
(5, 12, '2021-01-06 20:06:10', NULL, NULL),
(6, 13, '2021-01-06 20:06:10', NULL, NULL),
(7, 14, '2021-01-06 20:06:10', NULL, NULL),
(8, 15, '2021-01-06 20:06:10', NULL, NULL),
(9, 16, '2021-01-06 20:06:10', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patient_reports`
--

CREATE TABLE `patient_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `consultation_id` bigint(20) UNSIGNED NOT NULL,
  `report_file` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'admin', '2021-01-06 20:06:07', NULL, NULL),
(2, 'Patient', 'patient', '2021-01-06 20:06:07', NULL, NULL),
(3, 'Doctor', 'doctor', '2021-01-06 20:06:07', NULL, NULL),
(4, 'Blood_bank_staff', 'blood_bank_staff', '2021-01-06 20:06:07', NULL, NULL),
(5, 'Blood_donor', 'blood_donor', '2021-01-06 20:06:07', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-01-06 20:06:08', '2021-01-06 20:06:08'),
(2, 2, '2021-01-06 20:06:08', '2021-01-06 20:06:08'),
(3, 2, '2021-01-06 20:06:08', '2021-01-06 20:06:08'),
(4, 3, '2021-01-06 20:06:08', '2021-01-06 20:06:08'),
(5, 3, '2021-01-06 20:06:08', '2021-01-06 20:06:08'),
(6, 3, '2021-01-06 20:06:08', '2021-01-06 20:06:08'),
(7, 2, '2021-01-06 20:06:08', '2021-01-06 20:06:08'),
(8, 3, '2021-01-06 20:06:08', '2021-01-06 20:06:08'),
(9, 3, '2021-01-06 20:06:09', '2021-01-06 20:06:09'),
(10, 3, '2021-01-06 20:06:09', '2021-01-06 20:06:09'),
(11, 2, '2021-01-06 20:06:09', '2021-01-06 20:06:09'),
(12, 2, '2021-01-06 20:06:09', '2021-01-06 20:06:09'),
(13, 2, '2021-01-06 20:06:09', '2021-01-06 20:06:09'),
(14, 2, '2021-01-06 20:06:09', '2021-01-06 20:06:09'),
(15, 2, '2021-01-06 20:06:09', '2021-01-06 20:06:09'),
(16, 2, '2021-01-06 20:06:09', '2021-01-06 20:06:09'),
(17, 3, '2021-01-06 20:06:09', '2021-01-06 20:06:09'),
(18, 3, '2021-01-06 20:06:09', '2021-01-06 20:06:09'),
(19, 3, '2021-01-06 20:06:10', '2021-01-06 20:06:10'),
(20, 3, '2021-01-06 20:06:10', '2021-01-06 20:06:10'),
(21, 3, '2021-01-06 20:06:10', '2021-01-06 20:06:10'),
(22, 3, '2021-01-06 20:06:10', '2021-01-06 20:06:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '/storage/user_data/patient/avatar_default.png',
  `blood_group` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blocked` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `email_verified_at`, `password`, `dob`, `phone`, `gender`, `avatar`, `blood_group`, `location`, `address`, `blocked`, `status`, `is_admin`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'User', 'admin_user@gmail.com', '2019-08-20 18:00:00', '$2y$10$oJeYlPnAqvp41l8IuNg5nOA38MMYjN9TQpcH7iOSSA3g7Gbglzdh2', '1996-08-21', '01857823870', 'male', '/storage/user_data/admin/Admin.gif', 'B+', 'eyJpdiI6IkdQeFwvOU9HbTloU2h5YWkzbmhJZEt3PT0iLCJ2YWx1ZSI6IlwvK2FCeWk0bVRYeCtWNVZcL3BzNExyYUM0UGMwZXNublo1OEhcL1cyRzVKU2V2RGZpU2lrenByU2FQSFwvTnVzYTZjQ2M1alhiXC9kekx0NnU1T1VJRGprK3dxRUtwbWFUMEMxenBidnFHeU5velZCSkZHZjI4R3hEWU9JN0V3dmwzRlhGVjRZY0RJcGVuSlZMNWhNODFyMDY4eGdBcm1SY1dhazFaY1JpTW9zMWsrUXk1akgxNkVIcXppeWlWWWtPa3FDSlZHTEtPQSs2cUo2aWtOejBoSk5xd1NuZXRFOTNiOHlhNjAzdG1NYXZOTktBY1I5ZnRxNHFRMWVPdGxLM0thR3QrMlRcL0QrWDBzU3ZtN1RFU2lYSmM0RkVxOUp2MXhaT2Z3dWJaVXRxcTVXZE1IWXpnQUQwcjlLODJNaFBcL2duM0ErTXBuVjFxWVdjMkVUR0lGdmQ5Y25tRDB4TFU2RERCXC9iMHFoNmJ3bHV3NDYxU2V0R05nRFpJc3NVTTFoOFk1ZlpVN2hHa2RyTWxienE3YXRKU1IxTDlmMGtwRDZiUU0xNlhhK3pZWlhiUTJNT28yTmFPd1hPRzBZRzFQakdHaHprdXh5dEJOQ25tb1BEbVwveE5CK3FHWGlWamxGOTdZcUxqSU1YQU1TWlV5b29RUmc3MndOZ1hnejB1Z0U3dFVtWVllQ3gyRWd2dkk5UjZwOG9LUzgwNFlCYXJqKytSalFhUktNeFF1Q1phY0FSSVRGU2lJcjRkMHpWdFJcL1NBYk0iLCJtYWMiOiI5NDc2Nzk0NjRmM2JiNzQ3OWJmMzIxZGM3YWQ4NjNlZGRjZTIzZDFjOWJlODlkMDEwZjE0ZTRjNzc3ODlmNzYyIn0=', 'Kalabagan, Dhaka 1205', 0, 0, 1, NULL, '2021-01-06 20:06:08', NULL, NULL),
(2, 'Nahid', 'Ferdous', 'nahidferdous2@gmail.com', '2019-08-20 18:00:00', '$2y$10$./uz676J2/qVTwmlegw6jeXBIwQdSNyNkA6WqE/eoIbIvMDxLFVm2', '1997-09-13', '01357823871', 'male', '/storage/user_data/patient/Nahid.gif', 'B+', 'eyJpdiI6IkdQeFwvOU9HbTloU2h5YWkzbmhJZEt3PT0iLCJ2YWx1ZSI6IlwvK2FCeWk0bVRYeCtWNVZcL3BzNExyYUM0UGMwZXNublo1OEhcL1cyRzVKU2V2RGZpU2lrenByU2FQSFwvTnVzYTZjQ2M1alhiXC9kekx0NnU1T1VJRGprK3dxRUtwbWFUMEMxenBidnFHeU5velZCSkZHZjI4R3hEWU9JN0V3dmwzRlhGVjRZY0RJcGVuSlZMNWhNODFyMDY4eGdBcm1SY1dhazFaY1JpTW9zMWsrUXk1akgxNkVIcXppeWlWWWtPa3FDSlZHTEtPQSs2cUo2aWtOejBoSk5xd1NuZXRFOTNiOHlhNjAzdG1NYXZOTktBY1I5ZnRxNHFRMWVPdGxLM0thR3QrMlRcL0QrWDBzU3ZtN1RFU2lYSmM0RkVxOUp2MXhaT2Z3dWJaVXRxcTVXZE1IWXpnQUQwcjlLODJNaFBcL2duM0ErTXBuVjFxWVdjMkVUR0lGdmQ5Y25tRDB4TFU2RERCXC9iMHFoNmJ3bHV3NDYxU2V0R05nRFpJc3NVTTFoOFk1ZlpVN2hHa2RyTWxienE3YXRKU1IxTDlmMGtwRDZiUU0xNlhhK3pZWlhiUTJNT28yTmFPd1hPRzBZRzFQakdHaHprdXh5dEJOQ25tb1BEbVwveE5CK3FHWGlWamxGOTdZcUxqSU1YQU1TWlV5b29RUmc3MndOZ1hnejB1Z0U3dFVtWVllQ3gyRWd2dkk5UjZwOG9LUzgwNFlCYXJqKytSalFhUktNeFF1Q1phY0FSSVRGU2lJcjRkMHpWdFJcL1NBYk0iLCJtYWMiOiI5NDc2Nzk0NjRmM2JiNzQ3OWJmMzIxZGM3YWQ4NjNlZGRjZTIzZDFjOWJlODlkMDEwZjE0ZTRjNzc3ODlmNzYyIn0=', 'Kalabagan, Dhaka 1205', 0, 0, 0, NULL, '2021-01-06 20:06:08', NULL, NULL),
(3, 'Abu', 'Hider', 'abuhider@gmail.com', NULL, '$2y$10$CZIsfRM.vZ/XtmUC8BFo6OkBioXeM7OOVNdaGq4daYqJDCIr/RpAu', '1987-12-01', '01857823872', 'male', '/storage/user_data/patient/male_user.png', 'B+', 'eyJpdiI6IkdQeFwvOU9HbTloU2h5YWkzbmhJZEt3PT0iLCJ2YWx1ZSI6IlwvK2FCeWk0bVRYeCtWNVZcL3BzNExyYUM0UGMwZXNublo1OEhcL1cyRzVKU2V2RGZpU2lrenByU2FQSFwvTnVzYTZjQ2M1alhiXC9kekx0NnU1T1VJRGprK3dxRUtwbWFUMEMxenBidnFHeU5velZCSkZHZjI4R3hEWU9JN0V3dmwzRlhGVjRZY0RJcGVuSlZMNWhNODFyMDY4eGdBcm1SY1dhazFaY1JpTW9zMWsrUXk1akgxNkVIcXppeWlWWWtPa3FDSlZHTEtPQSs2cUo2aWtOejBoSk5xd1NuZXRFOTNiOHlhNjAzdG1NYXZOTktBY1I5ZnRxNHFRMWVPdGxLM0thR3QrMlRcL0QrWDBzU3ZtN1RFU2lYSmM0RkVxOUp2MXhaT2Z3dWJaVXRxcTVXZE1IWXpnQUQwcjlLODJNaFBcL2duM0ErTXBuVjFxWVdjMkVUR0lGdmQ5Y25tRDB4TFU2RERCXC9iMHFoNmJ3bHV3NDYxU2V0R05nRFpJc3NVTTFoOFk1ZlpVN2hHa2RyTWxienE3YXRKU1IxTDlmMGtwRDZiUU0xNlhhK3pZWlhiUTJNT28yTmFPd1hPRzBZRzFQakdHaHprdXh5dEJOQ25tb1BEbVwveE5CK3FHWGlWamxGOTdZcUxqSU1YQU1TWlV5b29RUmc3MndOZ1hnejB1Z0U3dFVtWVllQ3gyRWd2dkk5UjZwOG9LUzgwNFlCYXJqKytSalFhUktNeFF1Q1phY0FSSVRGU2lJcjRkMHpWdFJcL1NBYk0iLCJtYWMiOiI5NDc2Nzk0NjRmM2JiNzQ3OWJmMzIxZGM3YWQ4NjNlZGRjZTIzZDFjOWJlODlkMDEwZjE0ZTRjNzc3ODlmNzYyIn0=', 'Pantapath, Dhaka 1205', 0, 0, 0, NULL, '2021-01-06 20:06:08', NULL, NULL),
(4, 'Mizanur', 'Rahman', 'mizanur_rahman@gmail.com', '2021-01-06 20:06:08', '$2y$10$xKr5Y97mQ0G3JKZDzOG.wegDM5qSWehcpaPo1qOs8.7J6Bl3ahuVi', '1990-10-20', '01457823873', 'male', '/storage/user_data/doctor/mizanur_rahman.jpg', 'O+', 'eyJpdiI6IkdQeFwvOU9HbTloU2h5YWkzbmhJZEt3PT0iLCJ2YWx1ZSI6IlwvK2FCeWk0bVRYeCtWNVZcL3BzNExyYUM0UGMwZXNublo1OEhcL1cyRzVKU2V2RGZpU2lrenByU2FQSFwvTnVzYTZjQ2M1alhiXC9kekx0NnU1T1VJRGprK3dxRUtwbWFUMEMxenBidnFHeU5velZCSkZHZjI4R3hEWU9JN0V3dmwzRlhGVjRZY0RJcGVuSlZMNWhNODFyMDY4eGdBcm1SY1dhazFaY1JpTW9zMWsrUXk1akgxNkVIcXppeWlWWWtPa3FDSlZHTEtPQSs2cUo2aWtOejBoSk5xd1NuZXRFOTNiOHlhNjAzdG1NYXZOTktBY1I5ZnRxNHFRMWVPdGxLM0thR3QrMlRcL0QrWDBzU3ZtN1RFU2lYSmM0RkVxOUp2MXhaT2Z3dWJaVXRxcTVXZE1IWXpnQUQwcjlLODJNaFBcL2duM0ErTXBuVjFxWVdjMkVUR0lGdmQ5Y25tRDB4TFU2RERCXC9iMHFoNmJ3bHV3NDYxU2V0R05nRFpJc3NVTTFoOFk1ZlpVN2hHa2RyTWxienE3YXRKU1IxTDlmMGtwRDZiUU0xNlhhK3pZWlhiUTJNT28yTmFPd1hPRzBZRzFQakdHaHprdXh5dEJOQ25tb1BEbVwveE5CK3FHWGlWamxGOTdZcUxqSU1YQU1TWlV5b29RUmc3MndOZ1hnejB1Z0U3dFVtWVllQ3gyRWd2dkk5UjZwOG9LUzgwNFlCYXJqKytSalFhUktNeFF1Q1phY0FSSVRGU2lJcjRkMHpWdFJcL1NBYk0iLCJtYWMiOiI5NDc2Nzk0NjRmM2JiNzQ3OWJmMzIxZGM3YWQ4NjNlZGRjZTIzZDFjOWJlODlkMDEwZjE0ZTRjNzc3ODlmNzYyIn0=', 'Kalabagan, Dhaka 1205', 1, 0, 0, NULL, '2021-01-06 20:06:08', NULL, NULL),
(5, 'Mahid', 'Hasan', 'mahid_hasan@gmail.com', '2021-01-06 20:06:08', '$2y$10$YIOzsVYWulglw91MN2kb7O5L9q1jy7XUxwRWaSpPNrWsBNB7DipRi', '1988-04-12', '01357823874', 'male', '/storage/user_data/doctor/Mahid_Hasan.jpg', 'O-', 'eyJpdiI6IkdQeFwvOU9HbTloU2h5YWkzbmhJZEt3PT0iLCJ2YWx1ZSI6IlwvK2FCeWk0bVRYeCtWNVZcL3BzNExyYUM0UGMwZXNublo1OEhcL1cyRzVKU2V2RGZpU2lrenByU2FQSFwvTnVzYTZjQ2M1alhiXC9kekx0NnU1T1VJRGprK3dxRUtwbWFUMEMxenBidnFHeU5velZCSkZHZjI4R3hEWU9JN0V3dmwzRlhGVjRZY0RJcGVuSlZMNWhNODFyMDY4eGdBcm1SY1dhazFaY1JpTW9zMWsrUXk1akgxNkVIcXppeWlWWWtPa3FDSlZHTEtPQSs2cUo2aWtOejBoSk5xd1NuZXRFOTNiOHlhNjAzdG1NYXZOTktBY1I5ZnRxNHFRMWVPdGxLM0thR3QrMlRcL0QrWDBzU3ZtN1RFU2lYSmM0RkVxOUp2MXhaT2Z3dWJaVXRxcTVXZE1IWXpnQUQwcjlLODJNaFBcL2duM0ErTXBuVjFxWVdjMkVUR0lGdmQ5Y25tRDB4TFU2RERCXC9iMHFoNmJ3bHV3NDYxU2V0R05nRFpJc3NVTTFoOFk1ZlpVN2hHa2RyTWxienE3YXRKU1IxTDlmMGtwRDZiUU0xNlhhK3pZWlhiUTJNT28yTmFPd1hPRzBZRzFQakdHaHprdXh5dEJOQ25tb1BEbVwveE5CK3FHWGlWamxGOTdZcUxqSU1YQU1TWlV5b29RUmc3MndOZ1hnejB1Z0U3dFVtWVllQ3gyRWd2dkk5UjZwOG9LUzgwNFlCYXJqKytSalFhUktNeFF1Q1phY0FSSVRGU2lJcjRkMHpWdFJcL1NBYk0iLCJtYWMiOiI5NDc2Nzk0NjRmM2JiNzQ3OWJmMzIxZGM3YWQ4NjNlZGRjZTIzZDFjOWJlODlkMDEwZjE0ZTRjNzc3ODlmNzYyIn0=', 'Polton, Dhaka 1205', 0, 0, 0, NULL, '2021-01-06 20:06:08', NULL, NULL),
(6, 'Abdul', 'Aziz', 'abdul_azim@gmail.com', NULL, '$2y$10$m7zvcTGy4TI0rKHVez1bUOX5oFzW1QCGkAmz/KzFaOd2mOGz3EpX2', '1974-06-10', '01957823874', 'male', '/storage/user_data/doctor/abdul_azim.jpg', 'O-', 'eyJpdiI6IkdQeFwvOU9HbTloU2h5YWkzbmhJZEt3PT0iLCJ2YWx1ZSI6IlwvK2FCeWk0bVRYeCtWNVZcL3BzNExyYUM0UGMwZXNublo1OEhcL1cyRzVKU2V2RGZpU2lrenByU2FQSFwvTnVzYTZjQ2M1alhiXC9kekx0NnU1T1VJRGprK3dxRUtwbWFUMEMxenBidnFHeU5velZCSkZHZjI4R3hEWU9JN0V3dmwzRlhGVjRZY0RJcGVuSlZMNWhNODFyMDY4eGdBcm1SY1dhazFaY1JpTW9zMWsrUXk1akgxNkVIcXppeWlWWWtPa3FDSlZHTEtPQSs2cUo2aWtOejBoSk5xd1NuZXRFOTNiOHlhNjAzdG1NYXZOTktBY1I5ZnRxNHFRMWVPdGxLM0thR3QrMlRcL0QrWDBzU3ZtN1RFU2lYSmM0RkVxOUp2MXhaT2Z3dWJaVXRxcTVXZE1IWXpnQUQwcjlLODJNaFBcL2duM0ErTXBuVjFxWVdjMkVUR0lGdmQ5Y25tRDB4TFU2RERCXC9iMHFoNmJ3bHV3NDYxU2V0R05nRFpJc3NVTTFoOFk1ZlpVN2hHa2RyTWxienE3YXRKU1IxTDlmMGtwRDZiUU0xNlhhK3pZWlhiUTJNT28yTmFPd1hPRzBZRzFQakdHaHprdXh5dEJOQ25tb1BEbVwveE5CK3FHWGlWamxGOTdZcUxqSU1YQU1TWlV5b29RUmc3MndOZ1hnejB1Z0U3dFVtWVllQ3gyRWd2dkk5UjZwOG9LUzgwNFlCYXJqKytSalFhUktNeFF1Q1phY0FSSVRGU2lJcjRkMHpWdFJcL1NBYk0iLCJtYWMiOiI5NDc2Nzk0NjRmM2JiNzQ3OWJmMzIxZGM3YWQ4NjNlZGRjZTIzZDFjOWJlODlkMDEwZjE0ZTRjNzc3ODlmNzYyIn0=', 'Polton, Dhaka 1205', 0, 0, 0, NULL, '2021-01-06 20:06:08', NULL, NULL),
(7, 'Google', 'Boy', 'google@gmail.com', NULL, '$2y$10$hQWQx7NRzISrNz5.7ZLzTuMl3VPUeDUX4NNj0yzCTElNXUAc0p2Ui', '1982-02-02', '01878823872', 'male', '/storage/user_data/patient/nahidferdous.jpg', 'A+', 'eyJpdiI6IkdQeFwvOU9HbTloU2h5YWkzbmhJZEt3PT0iLCJ2YWx1ZSI6IlwvK2FCeWk0bVRYeCtWNVZcL3BzNExyYUM0UGMwZXNublo1OEhcL1cyRzVKU2V2RGZpU2lrenByU2FQSFwvTnVzYTZjQ2M1alhiXC9kekx0NnU1T1VJRGprK3dxRUtwbWFUMEMxenBidnFHeU5velZCSkZHZjI4R3hEWU9JN0V3dmwzRlhGVjRZY0RJcGVuSlZMNWhNODFyMDY4eGdBcm1SY1dhazFaY1JpTW9zMWsrUXk1akgxNkVIcXppeWlWWWtPa3FDSlZHTEtPQSs2cUo2aWtOejBoSk5xd1NuZXRFOTNiOHlhNjAzdG1NYXZOTktBY1I5ZnRxNHFRMWVPdGxLM0thR3QrMlRcL0QrWDBzU3ZtN1RFU2lYSmM0RkVxOUp2MXhaT2Z3dWJaVXRxcTVXZE1IWXpnQUQwcjlLODJNaFBcL2duM0ErTXBuVjFxWVdjMkVUR0lGdmQ5Y25tRDB4TFU2RERCXC9iMHFoNmJ3bHV3NDYxU2V0R05nRFpJc3NVTTFoOFk1ZlpVN2hHa2RyTWxienE3YXRKU1IxTDlmMGtwRDZiUU0xNlhhK3pZWlhiUTJNT28yTmFPd1hPRzBZRzFQakdHaHprdXh5dEJOQ25tb1BEbVwveE5CK3FHWGlWamxGOTdZcUxqSU1YQU1TWlV5b29RUmc3MndOZ1hnejB1Z0U3dFVtWVllQ3gyRWd2dkk5UjZwOG9LUzgwNFlCYXJqKytSalFhUktNeFF1Q1phY0FSSVRGU2lJcjRkMHpWdFJcL1NBYk0iLCJtYWMiOiI5NDc2Nzk0NjRmM2JiNzQ3OWJmMzIxZGM3YWQ4NjNlZGRjZTIzZDFjOWJlODlkMDEwZjE0ZTRjNzc3ODlmNzYyIn0=', 'Pantapath, Dhaka 1205', 0, 0, 0, NULL, '2021-01-06 20:06:08', NULL, NULL),
(8, 'Farjana', 'Alom', 'farjana_alom@gmail.com', '2021-01-06 20:06:08', '$2y$10$QnQg1e41HyuW2DuRVX3rCeMfbTzfvfrDD.F5NT9erFuUOhUiQ.hwe', '1995-08-21', '01857623872', 'female', '/storage/user_data/doctor/farjana_alom.jpg', 'B-', 'eyJpdiI6IkdQeFwvOU9HbTloU2h5YWkzbmhJZEt3PT0iLCJ2YWx1ZSI6IlwvK2FCeWk0bVRYeCtWNVZcL3BzNExyYUM0UGMwZXNublo1OEhcL1cyRzVKU2V2RGZpU2lrenByU2FQSFwvTnVzYTZjQ2M1alhiXC9kekx0NnU1T1VJRGprK3dxRUtwbWFUMEMxenBidnFHeU5velZCSkZHZjI4R3hEWU9JN0V3dmwzRlhGVjRZY0RJcGVuSlZMNWhNODFyMDY4eGdBcm1SY1dhazFaY1JpTW9zMWsrUXk1akgxNkVIcXppeWlWWWtPa3FDSlZHTEtPQSs2cUo2aWtOejBoSk5xd1NuZXRFOTNiOHlhNjAzdG1NYXZOTktBY1I5ZnRxNHFRMWVPdGxLM0thR3QrMlRcL0QrWDBzU3ZtN1RFU2lYSmM0RkVxOUp2MXhaT2Z3dWJaVXRxcTVXZE1IWXpnQUQwcjlLODJNaFBcL2duM0ErTXBuVjFxWVdjMkVUR0lGdmQ5Y25tRDB4TFU2RERCXC9iMHFoNmJ3bHV3NDYxU2V0R05nRFpJc3NVTTFoOFk1ZlpVN2hHa2RyTWxienE3YXRKU1IxTDlmMGtwRDZiUU0xNlhhK3pZWlhiUTJNT28yTmFPd1hPRzBZRzFQakdHaHprdXh5dEJOQ25tb1BEbVwveE5CK3FHWGlWamxGOTdZcUxqSU1YQU1TWlV5b29RUmc3MndOZ1hnejB1Z0U3dFVtWVllQ3gyRWd2dkk5UjZwOG9LUzgwNFlCYXJqKytSalFhUktNeFF1Q1phY0FSSVRGU2lJcjRkMHpWdFJcL1NBYk0iLCJtYWMiOiI5NDc2Nzk0NjRmM2JiNzQ3OWJmMzIxZGM3YWQ4NjNlZGRjZTIzZDFjOWJlODlkMDEwZjE0ZTRjNzc3ODlmNzYyIn0=', 'Pantapath, Dhaka 1205', 0, 0, 0, NULL, '2021-01-06 20:06:08', NULL, NULL),
(9, 'Nasir', 'Hossain', 'nasir@gmail.com', NULL, '$2y$10$O8pL83fNIxrotWRjxFWCaOvi/AcBmiQuipUjjrVa0rApzIGirf55O', '1986-08-21', '01897623872', 'male', '/storage/user_data/doctor/nasir.jpg', 'AB+', 'eyJpdiI6IkdQeFwvOU9HbTloU2h5YWkzbmhJZEt3PT0iLCJ2YWx1ZSI6IlwvK2FCeWk0bVRYeCtWNVZcL3BzNExyYUM0UGMwZXNublo1OEhcL1cyRzVKU2V2RGZpU2lrenByU2FQSFwvTnVzYTZjQ2M1alhiXC9kekx0NnU1T1VJRGprK3dxRUtwbWFUMEMxenBidnFHeU5velZCSkZHZjI4R3hEWU9JN0V3dmwzRlhGVjRZY0RJcGVuSlZMNWhNODFyMDY4eGdBcm1SY1dhazFaY1JpTW9zMWsrUXk1akgxNkVIcXppeWlWWWtPa3FDSlZHTEtPQSs2cUo2aWtOejBoSk5xd1NuZXRFOTNiOHlhNjAzdG1NYXZOTktBY1I5ZnRxNHFRMWVPdGxLM0thR3QrMlRcL0QrWDBzU3ZtN1RFU2lYSmM0RkVxOUp2MXhaT2Z3dWJaVXRxcTVXZE1IWXpnQUQwcjlLODJNaFBcL2duM0ErTXBuVjFxWVdjMkVUR0lGdmQ5Y25tRDB4TFU2RERCXC9iMHFoNmJ3bHV3NDYxU2V0R05nRFpJc3NVTTFoOFk1ZlpVN2hHa2RyTWxienE3YXRKU1IxTDlmMGtwRDZiUU0xNlhhK3pZWlhiUTJNT28yTmFPd1hPRzBZRzFQakdHaHprdXh5dEJOQ25tb1BEbVwveE5CK3FHWGlWamxGOTdZcUxqSU1YQU1TWlV5b29RUmc3MndOZ1hnejB1Z0U3dFVtWVllQ3gyRWd2dkk5UjZwOG9LUzgwNFlCYXJqKytSalFhUktNeFF1Q1phY0FSSVRGU2lJcjRkMHpWdFJcL1NBYk0iLCJtYWMiOiI5NDc2Nzk0NjRmM2JiNzQ3OWJmMzIxZGM3YWQ4NjNlZGRjZTIzZDFjOWJlODlkMDEwZjE0ZTRjNzc3ODlmNzYyIn0=', 'Pantapath, Dhaka 1205', 0, 0, 0, NULL, '2021-01-06 20:06:09', NULL, NULL),
(10, 'Rakib', 'Hosain', 'rakibhosain@gmail.com', '2021-01-06 20:06:09', '$2y$10$6hS.kAhvdMAtmUl1jy2./udyVf.riGEhps8ZeeQIze3cKUZecoN1y', '1996-07-21', '01897623372', 'male', '/storage/user_data/doctor/rakibhosain.jpg', 'AB+', 'eyJpdiI6IkdQeFwvOU9HbTloU2h5YWkzbmhJZEt3PT0iLCJ2YWx1ZSI6IlwvK2FCeWk0bVRYeCtWNVZcL3BzNExyYUM0UGMwZXNublo1OEhcL1cyRzVKU2V2RGZpU2lrenByU2FQSFwvTnVzYTZjQ2M1alhiXC9kekx0NnU1T1VJRGprK3dxRUtwbWFUMEMxenBidnFHeU5velZCSkZHZjI4R3hEWU9JN0V3dmwzRlhGVjRZY0RJcGVuSlZMNWhNODFyMDY4eGdBcm1SY1dhazFaY1JpTW9zMWsrUXk1akgxNkVIcXppeWlWWWtPa3FDSlZHTEtPQSs2cUo2aWtOejBoSk5xd1NuZXRFOTNiOHlhNjAzdG1NYXZOTktBY1I5ZnRxNHFRMWVPdGxLM0thR3QrMlRcL0QrWDBzU3ZtN1RFU2lYSmM0RkVxOUp2MXhaT2Z3dWJaVXRxcTVXZE1IWXpnQUQwcjlLODJNaFBcL2duM0ErTXBuVjFxWVdjMkVUR0lGdmQ5Y25tRDB4TFU2RERCXC9iMHFoNmJ3bHV3NDYxU2V0R05nRFpJc3NVTTFoOFk1ZlpVN2hHa2RyTWxienE3YXRKU1IxTDlmMGtwRDZiUU0xNlhhK3pZWlhiUTJNT28yTmFPd1hPRzBZRzFQakdHaHprdXh5dEJOQ25tb1BEbVwveE5CK3FHWGlWamxGOTdZcUxqSU1YQU1TWlV5b29RUmc3MndOZ1hnejB1Z0U3dFVtWVllQ3gyRWd2dkk5UjZwOG9LUzgwNFlCYXJqKytSalFhUktNeFF1Q1phY0FSSVRGU2lJcjRkMHpWdFJcL1NBYk0iLCJtYWMiOiI5NDc2Nzk0NjRmM2JiNzQ3OWJmMzIxZGM3YWQ4NjNlZGRjZTIzZDFjOWJlODlkMDEwZjE0ZTRjNzc3ODlmNzYyIn0=', 'Pantapath, Dhaka 1205', 0, 0, 0, NULL, '2021-01-06 20:06:09', NULL, NULL),
(11, 'Bikash', 'Chowdhury', 'bikash123@gmail.com', '2021-01-06 20:06:09', '$2y$10$0l0DQAzbJPDjDLd98VzCaudOcOL3WN678c7ET2UnTaHhwJhPLvbd.', '1992-07-21', '01897623373', 'male', '/storage/user_data/patient/bikash.jpeg', 'AB+', 'Bangladesh, Dhaka, Dhaka Division', 'Pantapath, Dhaka 1205', 0, 0, 0, NULL, '2021-01-06 20:06:09', '2021-05-10 09:54:24', NULL),
(12, 'Hero', 'Alom', 'heroalom@gmail.com', '2021-01-06 20:06:09', '$2y$10$Kc2GJEy9QIZ8bc0/e1FaOuq9VLPWGM0dFrHTqJQU8D3OsyHlWBUw6', '1995-07-21', '01897653372', 'male', '/storage/user_data/patient/heroalom.jpg', 'O+', 'eyJpdiI6IkdQeFwvOU9HbTloU2h5YWkzbmhJZEt3PT0iLCJ2YWx1ZSI6IlwvK2FCeWk0bVRYeCtWNVZcL3BzNExyYUM0UGMwZXNublo1OEhcL1cyRzVKU2V2RGZpU2lrenByU2FQSFwvTnVzYTZjQ2M1alhiXC9kekx0NnU1T1VJRGprK3dxRUtwbWFUMEMxenBidnFHeU5velZCSkZHZjI4R3hEWU9JN0V3dmwzRlhGVjRZY0RJcGVuSlZMNWhNODFyMDY4eGdBcm1SY1dhazFaY1JpTW9zMWsrUXk1akgxNkVIcXppeWlWWWtPa3FDSlZHTEtPQSs2cUo2aWtOejBoSk5xd1NuZXRFOTNiOHlhNjAzdG1NYXZOTktBY1I5ZnRxNHFRMWVPdGxLM0thR3QrMlRcL0QrWDBzU3ZtN1RFU2lYSmM0RkVxOUp2MXhaT2Z3dWJaVXRxcTVXZE1IWXpnQUQwcjlLODJNaFBcL2duM0ErTXBuVjFxWVdjMkVUR0lGdmQ5Y25tRDB4TFU2RERCXC9iMHFoNmJ3bHV3NDYxU2V0R05nRFpJc3NVTTFoOFk1ZlpVN2hHa2RyTWxienE3YXRKU1IxTDlmMGtwRDZiUU0xNlhhK3pZWlhiUTJNT28yTmFPd1hPRzBZRzFQakdHaHprdXh5dEJOQ25tb1BEbVwveE5CK3FHWGlWamxGOTdZcUxqSU1YQU1TWlV5b29RUmc3MndOZ1hnejB1Z0U3dFVtWVllQ3gyRWd2dkk5UjZwOG9LUzgwNFlCYXJqKytSalFhUktNeFF1Q1phY0FSSVRGU2lJcjRkMHpWdFJcL1NBYk0iLCJtYWMiOiI5NDc2Nzk0NjRmM2JiNzQ3OWJmMzIxZGM3YWQ4NjNlZGRjZTIzZDFjOWJlODlkMDEwZjE0ZTRjNzc3ODlmNzYyIn0=', 'Pantapath, Dhaka 1205', 0, 0, 0, NULL, '2021-01-06 20:06:09', NULL, NULL),
(13, 'Imran', 'Ali', '1000820@daffodil.ac', '2021-01-06 20:06:09', '$2y$10$4lI3sAAXGH296muDE37WgOb46vtsJcIDgiG9rVJVEgc.GBGdW2.OK', '1994-07-21', '01891623372', 'male', '/storage/user_data/patient/imran.jpeg', 'A+', 'eyJpdiI6IkdQeFwvOU9HbTloU2h5YWkzbmhJZEt3PT0iLCJ2YWx1ZSI6IlwvK2FCeWk0bVRYeCtWNVZcL3BzNExyYUM0UGMwZXNublo1OEhcL1cyRzVKU2V2RGZpU2lrenByU2FQSFwvTnVzYTZjQ2M1alhiXC9kekx0NnU1T1VJRGprK3dxRUtwbWFUMEMxenBidnFHeU5velZCSkZHZjI4R3hEWU9JN0V3dmwzRlhGVjRZY0RJcGVuSlZMNWhNODFyMDY4eGdBcm1SY1dhazFaY1JpTW9zMWsrUXk1akgxNkVIcXppeWlWWWtPa3FDSlZHTEtPQSs2cUo2aWtOejBoSk5xd1NuZXRFOTNiOHlhNjAzdG1NYXZOTktBY1I5ZnRxNHFRMWVPdGxLM0thR3QrMlRcL0QrWDBzU3ZtN1RFU2lYSmM0RkVxOUp2MXhaT2Z3dWJaVXRxcTVXZE1IWXpnQUQwcjlLODJNaFBcL2duM0ErTXBuVjFxWVdjMkVUR0lGdmQ5Y25tRDB4TFU2RERCXC9iMHFoNmJ3bHV3NDYxU2V0R05nRFpJc3NVTTFoOFk1ZlpVN2hHa2RyTWxienE3YXRKU1IxTDlmMGtwRDZiUU0xNlhhK3pZWlhiUTJNT28yTmFPd1hPRzBZRzFQakdHaHprdXh5dEJOQ25tb1BEbVwveE5CK3FHWGlWamxGOTdZcUxqSU1YQU1TWlV5b29RUmc3MndOZ1hnejB1Z0U3dFVtWVllQ3gyRWd2dkk5UjZwOG9LUzgwNFlCYXJqKytSalFhUktNeFF1Q1phY0FSSVRGU2lJcjRkMHpWdFJcL1NBYk0iLCJtYWMiOiI5NDc2Nzk0NjRmM2JiNzQ3OWJmMzIxZGM3YWQ4NjNlZGRjZTIzZDFjOWJlODlkMDEwZjE0ZTRjNzc3ODlmNzYyIn0=', 'Pantapath, Dhaka 1205', 0, 0, 0, NULL, '2021-01-06 20:06:09', NULL, NULL),
(14, 'Khorshed', 'Alom', '1000816@daffodil.ac', '2021-01-06 20:06:09', '$2y$10$OHRTx/vDdG0N/8Gd/50fJOyqfrhS83s3ZuGqgmVVN2taZtBOi0XbO', '1990-07-21', '01897614572', 'male', '/storage/user_data/patient/Khorshed_Alom.jpg', 'AB+', 'eyJpdiI6IkdQeFwvOU9HbTloU2h5YWkzbmhJZEt3PT0iLCJ2YWx1ZSI6IlwvK2FCeWk0bVRYeCtWNVZcL3BzNExyYUM0UGMwZXNublo1OEhcL1cyRzVKU2V2RGZpU2lrenByU2FQSFwvTnVzYTZjQ2M1alhiXC9kekx0NnU1T1VJRGprK3dxRUtwbWFUMEMxenBidnFHeU5velZCSkZHZjI4R3hEWU9JN0V3dmwzRlhGVjRZY0RJcGVuSlZMNWhNODFyMDY4eGdBcm1SY1dhazFaY1JpTW9zMWsrUXk1akgxNkVIcXppeWlWWWtPa3FDSlZHTEtPQSs2cUo2aWtOejBoSk5xd1NuZXRFOTNiOHlhNjAzdG1NYXZOTktBY1I5ZnRxNHFRMWVPdGxLM0thR3QrMlRcL0QrWDBzU3ZtN1RFU2lYSmM0RkVxOUp2MXhaT2Z3dWJaVXRxcTVXZE1IWXpnQUQwcjlLODJNaFBcL2duM0ErTXBuVjFxWVdjMkVUR0lGdmQ5Y25tRDB4TFU2RERCXC9iMHFoNmJ3bHV3NDYxU2V0R05nRFpJc3NVTTFoOFk1ZlpVN2hHa2RyTWxienE3YXRKU1IxTDlmMGtwRDZiUU0xNlhhK3pZWlhiUTJNT28yTmFPd1hPRzBZRzFQakdHaHprdXh5dEJOQ25tb1BEbVwveE5CK3FHWGlWamxGOTdZcUxqSU1YQU1TWlV5b29RUmc3MndOZ1hnejB1Z0U3dFVtWVllQ3gyRWd2dkk5UjZwOG9LUzgwNFlCYXJqKytSalFhUktNeFF1Q1phY0FSSVRGU2lJcjRkMHpWdFJcL1NBYk0iLCJtYWMiOiI5NDc2Nzk0NjRmM2JiNzQ3OWJmMzIxZGM3YWQ4NjNlZGRjZTIzZDFjOWJlODlkMDEwZjE0ZTRjNzc3ODlmNzYyIn0=', 'Pantapath, Dhaka 1205', 0, 0, 0, NULL, '2021-01-06 20:06:09', NULL, NULL),
(15, 'Mohaminul', 'Islam', '1000812@daffodil.ac', '2021-01-06 20:06:09', '$2y$10$FgaYUC0fIhXhYKnPv23kxe14NHTegrbTdvr8ffaApSb0QqpU5s6gu', '1994-07-21', '01891193372', 'male', '/storage/user_data/patient/Mohaminul_Islam.jpg', 'AB+', 'eyJpdiI6IkdQeFwvOU9HbTloU2h5YWkzbmhJZEt3PT0iLCJ2YWx1ZSI6IlwvK2FCeWk0bVRYeCtWNVZcL3BzNExyYUM0UGMwZXNublo1OEhcL1cyRzVKU2V2RGZpU2lrenByU2FQSFwvTnVzYTZjQ2M1alhiXC9kekx0NnU1T1VJRGprK3dxRUtwbWFUMEMxenBidnFHeU5velZCSkZHZjI4R3hEWU9JN0V3dmwzRlhGVjRZY0RJcGVuSlZMNWhNODFyMDY4eGdBcm1SY1dhazFaY1JpTW9zMWsrUXk1akgxNkVIcXppeWlWWWtPa3FDSlZHTEtPQSs2cUo2aWtOejBoSk5xd1NuZXRFOTNiOHlhNjAzdG1NYXZOTktBY1I5ZnRxNHFRMWVPdGxLM0thR3QrMlRcL0QrWDBzU3ZtN1RFU2lYSmM0RkVxOUp2MXhaT2Z3dWJaVXRxcTVXZE1IWXpnQUQwcjlLODJNaFBcL2duM0ErTXBuVjFxWVdjMkVUR0lGdmQ5Y25tRDB4TFU2RERCXC9iMHFoNmJ3bHV3NDYxU2V0R05nRFpJc3NVTTFoOFk1ZlpVN2hHa2RyTWxienE3YXRKU1IxTDlmMGtwRDZiUU0xNlhhK3pZWlhiUTJNT28yTmFPd1hPRzBZRzFQakdHaHprdXh5dEJOQ25tb1BEbVwveE5CK3FHWGlWamxGOTdZcUxqSU1YQU1TWlV5b29RUmc3MndOZ1hnejB1Z0U3dFVtWVllQ3gyRWd2dkk5UjZwOG9LUzgwNFlCYXJqKytSalFhUktNeFF1Q1phY0FSSVRGU2lJcjRkMHpWdFJcL1NBYk0iLCJtYWMiOiI5NDc2Nzk0NjRmM2JiNzQ3OWJmMzIxZGM3YWQ4NjNlZGRjZTIzZDFjOWJlODlkMDEwZjE0ZTRjNzc3ODlmNzYyIn0=', 'Pantapath, Dhaka 1205', 0, 0, 0, NULL, '2021-01-06 20:06:09', NULL, NULL),
(16, 'Mohammad', 'Mahdi', '1000810@daffodil.ac', '2021-01-06 20:06:09', '$2y$10$P.15JhM/VVdZJJhuTlh9FeHFeWSq.vN./SE4sA.MzOP7n.gyFi/ay', '1992-08-21', '01891193382', 'male', '/storage/user_data/patient/mahdi.jpeg', 'O-', 'eyJpdiI6IkdQeFwvOU9HbTloU2h5YWkzbmhJZEt3PT0iLCJ2YWx1ZSI6IlwvK2FCeWk0bVRYeCtWNVZcL3BzNExyYUM0UGMwZXNublo1OEhcL1cyRzVKU2V2RGZpU2lrenByU2FQSFwvTnVzYTZjQ2M1alhiXC9kekx0NnU1T1VJRGprK3dxRUtwbWFUMEMxenBidnFHeU5velZCSkZHZjI4R3hEWU9JN0V3dmwzRlhGVjRZY0RJcGVuSlZMNWhNODFyMDY4eGdBcm1SY1dhazFaY1JpTW9zMWsrUXk1akgxNkVIcXppeWlWWWtPa3FDSlZHTEtPQSs2cUo2aWtOejBoSk5xd1NuZXRFOTNiOHlhNjAzdG1NYXZOTktBY1I5ZnRxNHFRMWVPdGxLM0thR3QrMlRcL0QrWDBzU3ZtN1RFU2lYSmM0RkVxOUp2MXhaT2Z3dWJaVXRxcTVXZE1IWXpnQUQwcjlLODJNaFBcL2duM0ErTXBuVjFxWVdjMkVUR0lGdmQ5Y25tRDB4TFU2RERCXC9iMHFoNmJ3bHV3NDYxU2V0R05nRFpJc3NVTTFoOFk1ZlpVN2hHa2RyTWxienE3YXRKU1IxTDlmMGtwRDZiUU0xNlhhK3pZWlhiUTJNT28yTmFPd1hPRzBZRzFQakdHaHprdXh5dEJOQ25tb1BEbVwveE5CK3FHWGlWamxGOTdZcUxqSU1YQU1TWlV5b29RUmc3MndOZ1hnejB1Z0U3dFVtWVllQ3gyRWd2dkk5UjZwOG9LUzgwNFlCYXJqKytSalFhUktNeFF1Q1phY0FSSVRGU2lJcjRkMHpWdFJcL1NBYk0iLCJtYWMiOiI5NDc2Nzk0NjRmM2JiNzQ3OWJmMzIxZGM3YWQ4NjNlZGRjZTIzZDFjOWJlODlkMDEwZjE0ZTRjNzc3ODlmNzYyIn0=', 'Pantapath, Dhaka 1205', 0, 0, 0, NULL, '2021-01-06 20:06:09', NULL, NULL),
(17, 'Kameron', 'Meagher', 'kameron@gmail.com', '2021-01-06 20:06:09', '$2y$10$KPz/lqKb1/jcb7F4Bt83cuRedSZINoaDU69pvAmBZU1UPaG40iw8y', '1992-08-21', '01741193382', 'male', '/storage/user_data/doctor/kameron.jpg', 'O-', 'eyJpdiI6IkdQeFwvOU9HbTloU2h5YWkzbmhJZEt3PT0iLCJ2YWx1ZSI6IlwvK2FCeWk0bVRYeCtWNVZcL3BzNExyYUM0UGMwZXNublo1OEhcL1cyRzVKU2V2RGZpU2lrenByU2FQSFwvTnVzYTZjQ2M1alhiXC9kekx0NnU1T1VJRGprK3dxRUtwbWFUMEMxenBidnFHeU5velZCSkZHZjI4R3hEWU9JN0V3dmwzRlhGVjRZY0RJcGVuSlZMNWhNODFyMDY4eGdBcm1SY1dhazFaY1JpTW9zMWsrUXk1akgxNkVIcXppeWlWWWtPa3FDSlZHTEtPQSs2cUo2aWtOejBoSk5xd1NuZXRFOTNiOHlhNjAzdG1NYXZOTktBY1I5ZnRxNHFRMWVPdGxLM0thR3QrMlRcL0QrWDBzU3ZtN1RFU2lYSmM0RkVxOUp2MXhaT2Z3dWJaVXRxcTVXZE1IWXpnQUQwcjlLODJNaFBcL2duM0ErTXBuVjFxWVdjMkVUR0lGdmQ5Y25tRDB4TFU2RERCXC9iMHFoNmJ3bHV3NDYxU2V0R05nRFpJc3NVTTFoOFk1ZlpVN2hHa2RyTWxienE3YXRKU1IxTDlmMGtwRDZiUU0xNlhhK3pZWlhiUTJNT28yTmFPd1hPRzBZRzFQakdHaHprdXh5dEJOQ25tb1BEbVwveE5CK3FHWGlWamxGOTdZcUxqSU1YQU1TWlV5b29RUmc3MndOZ1hnejB1Z0U3dFVtWVllQ3gyRWd2dkk5UjZwOG9LUzgwNFlCYXJqKytSalFhUktNeFF1Q1phY0FSSVRGU2lJcjRkMHpWdFJcL1NBYk0iLCJtYWMiOiI5NDc2Nzk0NjRmM2JiNzQ3OWJmMzIxZGM3YWQ4NjNlZGRjZTIzZDFjOWJlODlkMDEwZjE0ZTRjNzc3ODlmNzYyIn0=', 'New york city', 0, 0, 0, NULL, '2021-01-06 20:06:09', NULL, NULL),
(18, 'Nazmul', 'Ahsan', 'nazmul@gmail.com', '2021-01-06 20:06:09', '$2y$10$C8Wsvq//4MXWsdKz/1qFEOGotPlmnfrjVFLi2XeEAjD/m6FmlfsgW', '1992-08-21', '01895193382', 'male', '/storage/user_data/doctor/nazmul.jpg', 'O-', 'eyJpdiI6IkdQeFwvOU9HbTloU2h5YWkzbmhJZEt3PT0iLCJ2YWx1ZSI6IlwvK2FCeWk0bVRYeCtWNVZcL3BzNExyYUM0UGMwZXNublo1OEhcL1cyRzVKU2V2RGZpU2lrenByU2FQSFwvTnVzYTZjQ2M1alhiXC9kekx0NnU1T1VJRGprK3dxRUtwbWFUMEMxenBidnFHeU5velZCSkZHZjI4R3hEWU9JN0V3dmwzRlhGVjRZY0RJcGVuSlZMNWhNODFyMDY4eGdBcm1SY1dhazFaY1JpTW9zMWsrUXk1akgxNkVIcXppeWlWWWtPa3FDSlZHTEtPQSs2cUo2aWtOejBoSk5xd1NuZXRFOTNiOHlhNjAzdG1NYXZOTktBY1I5ZnRxNHFRMWVPdGxLM0thR3QrMlRcL0QrWDBzU3ZtN1RFU2lYSmM0RkVxOUp2MXhaT2Z3dWJaVXRxcTVXZE1IWXpnQUQwcjlLODJNaFBcL2duM0ErTXBuVjFxWVdjMkVUR0lGdmQ5Y25tRDB4TFU2RERCXC9iMHFoNmJ3bHV3NDYxU2V0R05nRFpJc3NVTTFoOFk1ZlpVN2hHa2RyTWxienE3YXRKU1IxTDlmMGtwRDZiUU0xNlhhK3pZWlhiUTJNT28yTmFPd1hPRzBZRzFQakdHaHprdXh5dEJOQ25tb1BEbVwveE5CK3FHWGlWamxGOTdZcUxqSU1YQU1TWlV5b29RUmc3MndOZ1hnejB1Z0U3dFVtWVllQ3gyRWd2dkk5UjZwOG9LUzgwNFlCYXJqKytSalFhUktNeFF1Q1phY0FSSVRGU2lJcjRkMHpWdFJcL1NBYk0iLCJtYWMiOiI5NDc2Nzk0NjRmM2JiNzQ3OWJmMzIxZGM3YWQ4NjNlZGRjZTIzZDFjOWJlODlkMDEwZjE0ZTRjNzc3ODlmNzYyIn0=', 'Gulshan, Dhaka 1205', 0, 0, 0, NULL, '2021-01-06 20:06:09', NULL, NULL),
(19, 'Fazlul', 'Hoque', 'fazlulhaque@gmail.com', '2021-01-06 20:06:09', '$2y$10$MOoRKqY1MGQaCPa.s45Ca..4fns9kmDrbPsNnZGt32mYmmxCscA7a', '1992-08-21', '01491193382', 'male', '/storage/user_data/doctor/fazlulhaque.jpg', 'O-', 'eyJpdiI6IkdQeFwvOU9HbTloU2h5YWkzbmhJZEt3PT0iLCJ2YWx1ZSI6IlwvK2FCeWk0bVRYeCtWNVZcL3BzNExyYUM0UGMwZXNublo1OEhcL1cyRzVKU2V2RGZpU2lrenByU2FQSFwvTnVzYTZjQ2M1alhiXC9kekx0NnU1T1VJRGprK3dxRUtwbWFUMEMxenBidnFHeU5velZCSkZHZjI4R3hEWU9JN0V3dmwzRlhGVjRZY0RJcGVuSlZMNWhNODFyMDY4eGdBcm1SY1dhazFaY1JpTW9zMWsrUXk1akgxNkVIcXppeWlWWWtPa3FDSlZHTEtPQSs2cUo2aWtOejBoSk5xd1NuZXRFOTNiOHlhNjAzdG1NYXZOTktBY1I5ZnRxNHFRMWVPdGxLM0thR3QrMlRcL0QrWDBzU3ZtN1RFU2lYSmM0RkVxOUp2MXhaT2Z3dWJaVXRxcTVXZE1IWXpnQUQwcjlLODJNaFBcL2duM0ErTXBuVjFxWVdjMkVUR0lGdmQ5Y25tRDB4TFU2RERCXC9iMHFoNmJ3bHV3NDYxU2V0R05nRFpJc3NVTTFoOFk1ZlpVN2hHa2RyTWxienE3YXRKU1IxTDlmMGtwRDZiUU0xNlhhK3pZWlhiUTJNT28yTmFPd1hPRzBZRzFQakdHaHprdXh5dEJOQ25tb1BEbVwveE5CK3FHWGlWamxGOTdZcUxqSU1YQU1TWlV5b29RUmc3MndOZ1hnejB1Z0U3dFVtWVllQ3gyRWd2dkk5UjZwOG9LUzgwNFlCYXJqKytSalFhUktNeFF1Q1phY0FSSVRGU2lJcjRkMHpWdFJcL1NBYk0iLCJtYWMiOiI5NDc2Nzk0NjRmM2JiNzQ3OWJmMzIxZGM3YWQ4NjNlZGRjZTIzZDFjOWJlODlkMDEwZjE0ZTRjNzc3ODlmNzYyIn0=', 'Dhanmondi, Dhaka 1205', 0, 0, 0, NULL, '2021-01-06 20:06:10', NULL, NULL),
(20, 'Mirza', 'Mohammad Hiron', 'hiron@gmail.com', '2021-01-06 20:06:10', '$2y$10$sNsKx/4Gykh2brfSWcAD7.s4YJfjdNyP1u7rEbjrAFzivPiZRpDV.', '1992-08-21', '01891393382', 'male', '/storage/user_data/doctor/hiron.jpg', 'O-', 'eyJpdiI6IkdQeFwvOU9HbTloU2h5YWkzbmhJZEt3PT0iLCJ2YWx1ZSI6IlwvK2FCeWk0bVRYeCtWNVZcL3BzNExyYUM0UGMwZXNublo1OEhcL1cyRzVKU2V2RGZpU2lrenByU2FQSFwvTnVzYTZjQ2M1alhiXC9kekx0NnU1T1VJRGprK3dxRUtwbWFUMEMxenBidnFHeU5velZCSkZHZjI4R3hEWU9JN0V3dmwzRlhGVjRZY0RJcGVuSlZMNWhNODFyMDY4eGdBcm1SY1dhazFaY1JpTW9zMWsrUXk1akgxNkVIcXppeWlWWWtPa3FDSlZHTEtPQSs2cUo2aWtOejBoSk5xd1NuZXRFOTNiOHlhNjAzdG1NYXZOTktBY1I5ZnRxNHFRMWVPdGxLM0thR3QrMlRcL0QrWDBzU3ZtN1RFU2lYSmM0RkVxOUp2MXhaT2Z3dWJaVXRxcTVXZE1IWXpnQUQwcjlLODJNaFBcL2duM0ErTXBuVjFxWVdjMkVUR0lGdmQ5Y25tRDB4TFU2RERCXC9iMHFoNmJ3bHV3NDYxU2V0R05nRFpJc3NVTTFoOFk1ZlpVN2hHa2RyTWxienE3YXRKU1IxTDlmMGtwRDZiUU0xNlhhK3pZWlhiUTJNT28yTmFPd1hPRzBZRzFQakdHaHprdXh5dEJOQ25tb1BEbVwveE5CK3FHWGlWamxGOTdZcUxqSU1YQU1TWlV5b29RUmc3MndOZ1hnejB1Z0U3dFVtWVllQ3gyRWd2dkk5UjZwOG9LUzgwNFlCYXJqKytSalFhUktNeFF1Q1phY0FSSVRGU2lJcjRkMHpWdFJcL1NBYk0iLCJtYWMiOiI5NDc2Nzk0NjRmM2JiNzQ3OWJmMzIxZGM3YWQ4NjNlZGRjZTIzZDFjOWJlODlkMDEwZjE0ZTRjNzc3ODlmNzYyIn0=', 'Pantapath, Dhaka 1205', 0, 0, 0, NULL, '2021-01-06 20:06:10', NULL, NULL),
(21, 'Manjur', 'Rahman', 'manjur_rahman@gmail.com', '2021-01-06 20:06:10', '$2y$10$9KQmTNmR8wmJrAQ4wITUmesUhoWT1oGrM2NmWtrlqZRjnN4nmARsC', '1992-08-21', '01892293382', 'male', '/storage/user_data/doctor/manjur_rahman.jpg', 'O-', 'eyJpdiI6IkdQeFwvOU9HbTloU2h5YWkzbmhJZEt3PT0iLCJ2YWx1ZSI6IlwvK2FCeWk0bVRYeCtWNVZcL3BzNExyYUM0UGMwZXNublo1OEhcL1cyRzVKU2V2RGZpU2lrenByU2FQSFwvTnVzYTZjQ2M1alhiXC9kekx0NnU1T1VJRGprK3dxRUtwbWFUMEMxenBidnFHeU5velZCSkZHZjI4R3hEWU9JN0V3dmwzRlhGVjRZY0RJcGVuSlZMNWhNODFyMDY4eGdBcm1SY1dhazFaY1JpTW9zMWsrUXk1akgxNkVIcXppeWlWWWtPa3FDSlZHTEtPQSs2cUo2aWtOejBoSk5xd1NuZXRFOTNiOHlhNjAzdG1NYXZOTktBY1I5ZnRxNHFRMWVPdGxLM0thR3QrMlRcL0QrWDBzU3ZtN1RFU2lYSmM0RkVxOUp2MXhaT2Z3dWJaVXRxcTVXZE1IWXpnQUQwcjlLODJNaFBcL2duM0ErTXBuVjFxWVdjMkVUR0lGdmQ5Y25tRDB4TFU2RERCXC9iMHFoNmJ3bHV3NDYxU2V0R05nRFpJc3NVTTFoOFk1ZlpVN2hHa2RyTWxienE3YXRKU1IxTDlmMGtwRDZiUU0xNlhhK3pZWlhiUTJNT28yTmFPd1hPRzBZRzFQakdHaHprdXh5dEJOQ25tb1BEbVwveE5CK3FHWGlWamxGOTdZcUxqSU1YQU1TWlV5b29RUmc3MndOZ1hnejB1Z0U3dFVtWVllQ3gyRWd2dkk5UjZwOG9LUzgwNFlCYXJqKytSalFhUktNeFF1Q1phY0FSSVRGU2lJcjRkMHpWdFJcL1NBYk0iLCJtYWMiOiI5NDc2Nzk0NjRmM2JiNzQ3OWJmMzIxZGM3YWQ4NjNlZGRjZTIzZDFjOWJlODlkMDEwZjE0ZTRjNzc3ODlmNzYyIn0=', 'Pantapath, Dhaka 1205', 0, 0, 0, NULL, '2021-01-06 20:06:10', NULL, NULL),
(22, 'Parvin', 'Akhter', 'parvin@gmail.com', '2021-01-06 20:06:10', '$2y$10$HbWcxV7hfy9ojIe..8fPNuJu93O7KS0dfhWRDVuWB3EEVUYRl.boq', '1992-08-21', '01894293382', 'male', '/storage/user_data/doctor/parvin.jpg', 'O-', 'eyJpdiI6IkdQeFwvOU9HbTloU2h5YWkzbmhJZEt3PT0iLCJ2YWx1ZSI6IlwvK2FCeWk0bVRYeCtWNVZcL3BzNExyYUM0UGMwZXNublo1OEhcL1cyRzVKU2V2RGZpU2lrenByU2FQSFwvTnVzYTZjQ2M1alhiXC9kekx0NnU1T1VJRGprK3dxRUtwbWFUMEMxenBidnFHeU5velZCSkZHZjI4R3hEWU9JN0V3dmwzRlhGVjRZY0RJcGVuSlZMNWhNODFyMDY4eGdBcm1SY1dhazFaY1JpTW9zMWsrUXk1akgxNkVIcXppeWlWWWtPa3FDSlZHTEtPQSs2cUo2aWtOejBoSk5xd1NuZXRFOTNiOHlhNjAzdG1NYXZOTktBY1I5ZnRxNHFRMWVPdGxLM0thR3QrMlRcL0QrWDBzU3ZtN1RFU2lYSmM0RkVxOUp2MXhaT2Z3dWJaVXRxcTVXZE1IWXpnQUQwcjlLODJNaFBcL2duM0ErTXBuVjFxWVdjMkVUR0lGdmQ5Y25tRDB4TFU2RERCXC9iMHFoNmJ3bHV3NDYxU2V0R05nRFpJc3NVTTFoOFk1ZlpVN2hHa2RyTWxienE3YXRKU1IxTDlmMGtwRDZiUU0xNlhhK3pZWlhiUTJNT28yTmFPd1hPRzBZRzFQakdHaHprdXh5dEJOQ25tb1BEbVwveE5CK3FHWGlWamxGOTdZcUxqSU1YQU1TWlV5b29RUmc3MndOZ1hnejB1Z0U3dFVtWVllQ3gyRWd2dkk5UjZwOG9LUzgwNFlCYXJqKytSalFhUktNeFF1Q1phY0FSSVRGU2lJcjRkMHpWdFJcL1NBYk0iLCJtYWMiOiI5NDc2Nzk0NjRmM2JiNzQ3OWJmMzIxZGM3YWQ4NjNlZGRjZTIzZDFjOWJlODlkMDEwZjE0ZTRjNzc3ODlmNzYyIn0=', 'Pantapath, Dhaka 1205', 0, 0, 0, NULL, '2021-01-06 20:06:10', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment_bookings`
--
ALTER TABLE `appointment_bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `appointment_bookings_token_unique` (`token`);

--
-- Indexes for table `appointment_requests`
--
ALTER TABLE `appointment_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blogs_title_unique` (`title`);

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_views`
--
ALTER TABLE `blog_views`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_department_name_unique` (`department_name`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `doctors_user_id_unique` (`user_id`);

--
-- Indexes for table `doctor_ratings`
--
ALTER TABLE `doctor_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emergency_conversations`
--
ALTER TABLE `emergency_conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_types`
--
ALTER TABLE `notification_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patients_user_id_unique` (`user_id`);

--
-- Indexes for table `patient_reports`
--
ALTER TABLE `patient_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD KEY `role_user_user_id_foreign` (`user_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `appointment_bookings`
--
ALTER TABLE `appointment_bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `appointment_requests`
--
ALTER TABLE `appointment_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `blog_comments`
--
ALTER TABLE `blog_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_views`
--
ALTER TABLE `blog_views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `doctor_ratings`
--
ALTER TABLE `doctor_ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `emergency_conversations`
--
ALTER TABLE `emergency_conversations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=451;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_types`
--
ALTER TABLE `notification_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `patient_reports`
--
ALTER TABLE `patient_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
