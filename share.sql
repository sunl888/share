-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-04-19 12:17:30
-- 服务器版本： 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `share`
--

-- --------------------------------------------------------

--
-- 表的结构 `categroies`
--

CREATE TABLE `categroies` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '分类',
  `pid` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'parent ID',
  `order_by` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '热门',
  `color` char(6) DEFAULT NULL COMMENT '颜色'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `categroies`
--

INSERT INTO `categroies` (`id`, `name`, `pid`, `order_by`, `color`) VALUES
(1, '前端开发', 0, 4, NULL),
(2, '后端开发', 0, 2, NULL),
(3, '移动开发', 0, 0, NULL),
(4, '网络安全', 0, 0, NULL),
(5, 'HTML', 1, 0, '61C2F8'),
(6, 'JavaScript', 1, 0, '993366'),
(7, 'jQuery', 1, 0, '0A91DA'),
(8, 'Node.js', 1, 0, 'ABDD78'),
(9, 'PHP', 2, 0, 'F01400'),
(10, 'Java', 2, 0, 'FF9900'),
(11, 'C', 2, 0, '51FF51'),
(12, 'C++', 2, 0, '0978B5'),
(13, 'Android', 3, 0, '0978B5'),
(14, 'iOS', 3, 0, 'CCCCCC'),
(15, 'Unity3D', 3, 0, '61C2F8'),
(16, 'MySQL', 4, 0, '333399'),
(17, 'Oracle', 4, 0, 'B690F7'),
(18, 'PhotoShop', 1, 0, '0A91DA'),
(19, 'Maya', 1, 0, 'Bf9fF7'),
(20, 'CSS', 1, 0, 'FF34B3'),
(21, 'WebApp', 1, 0, 'EE4000'),
(22, 'AngularJS', 1, 0, '00FF00'),
(23, 'Bootstrap', 1, 0, 'CDCD00'),
(24, 'Linux', 2, 0, 'CD2990'),
(25, 'Python', 2, 0, 'B3EE3A'),
(26, 'Go', 2, 0, '7CFC00'),
(27, 'C#', 2, 0, '63B8FF'),
(28, '数据结构', 2, 0, '00CD00'),
(29, 'Cocos2d', 3, 0, '424242'),
(30, 'MongoDB', 4, 0, 'CDB79E'),
(31, '大数据', 4, 0, 'FF8C00'),
(32, 'Swift', 3, 0, '0971B5');

-- --------------------------------------------------------

--
-- 表的结构 `categroies_videos`
--

CREATE TABLE `categroies_videos` (
  `vid` int(11) NOT NULL COMMENT 'videosID',
  `cid` int(11) NOT NULL COMMENT 'categroiesID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `likes`
--

CREATE TABLE `likes` (
  `id` int(11) UNSIGNED NOT NULL,
  `vid` int(11) NOT NULL COMMENT '视频ID',
  `uid` int(11) NOT NULL COMMENT '用户ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` char(32) NOT NULL,
  `password` char(32) NOT NULL,
  `face` varchar(255) DEFAULT NULL COMMENT '用户头像',
  `ctime` int(12) NOT NULL,
  `iden` varchar(32) DEFAULT NULL COMMENT '唯一标识'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `face`, `ctime`, `iden`) VALUES
(1, 'root', '63a9f0ea7bb98050796b649e85481845', NULL, 1468826263, '');


--
-- 表的结构 `videos`
--

CREATE TABLE `videos` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `uid` int(11) NOT NULL,
  `ctime` int(11) NOT NULL,
  `cover` varchar(255) DEFAULT NULL COMMENT '封面路径',
  `intro` varchar(512) DEFAULT NULL COMMENT '简介',
  `deleted_by` int(11) UNSIGNED DEFAULT '0',
  `likescount` int(11) NOT NULL DEFAULT '0' COMMENT '视频 赞 的个数',
  `views` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `videos_item`
--

CREATE TABLE `videos_item` (
  `id` mediumint(8) NOT NULL,
  `vid` int(11) NOT NULL COMMENT '视频id',
  `name` varchar(50) NOT NULL COMMENT '分类下的子视频名称',
  `size` int(11) NOT NULL COMMENT '视频的大小',
  `addr` varchar(255) NOT NULL COMMENT '视频的地址',
  `timelength` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 表的结构 `views`
--

CREATE TABLE `views` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_agent` varchar(255) NOT NULL COMMENT '用户主机型号',
  `user_name` char(20) NOT NULL COMMENT '如果用户登录了则记录用户名',
  `user_ip` char(15) NOT NULL COMMENT '用户ip',
  `vtime` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='浏览者信息';


--
-- Indexes for table `categroies`
--
ALTER TABLE `categroies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videos_item`
--
ALTER TABLE `videos_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `categroies`
--
ALTER TABLE `categroies`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- 使用表AUTO_INCREMENT `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- 使用表AUTO_INCREMENT `videos_item`
--
ALTER TABLE `videos_item`
  MODIFY `id` mediumint(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- 使用表AUTO_INCREMENT `views`
--
ALTER TABLE `views`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
