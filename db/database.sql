CREATE TABLE `rb_msg_log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '消息ID',
  `group` varchar(128) NOT NULL DEFAULT '' COMMENT '群组',
  `from` varchar(128) NOT NULL DEFAULT '' COMMENT '发送者',
  `content` varchar(1024) NOT NULL DEFAULT '' COMMENT '发送内容',
  `type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '发送类型(1:接收,2:发送)',
  `add_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT 0 COMMENT '修改时间',
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否删除(0:否,1:是)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='机器人消息表';
