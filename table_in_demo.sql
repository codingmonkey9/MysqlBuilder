
-- 建表语句： demo 中的api_count表
CREATE TABLE `api_count` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `channel_num` varchar(255) NOT NULL DEFAULT '' COMMENT '渠道号',
  `addtime` int(12) NOT NULL DEFAULT '0',
  `counter` int(11) NOT NULL DEFAULT '0' COMMENT '统计接口调用次数',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `updatetime` int(12) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC