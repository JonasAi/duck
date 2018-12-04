#!/usr/local/bin python3
# -*- coding: utf-8 -*-

import sqlparse
import sys
import getopt

def main(argv):
    inputfile = ''
    outputfile = ''
    try:
        opts, args = getopt.getopt(argv, "his:o:", ["ifile=", "--sql=", "ofile="])
    except getopt.GetoptError:
        print('test.py -i <inputfile> -o <outputfile>')
        sys.exit(2)
    for opt, arg in opts:
        if opt == '-h':
            print('test.py -i <inputfile> -o <outputfile>')
            sys.exit()
        elif opt in ("-s","--sql"):
            SQL = arg
        elif opt in ("-i", "--ifile"):
            inputfile = arg
        elif opt in ("-o", "--ofile"):
            outputfile = arg
    # print('输入的文件为：', inputfile)
    # print('输出的文件为：', outputfile)
    parsed = sqlparse.format(SQL, reindent=True, indent_width=2, keyword_case='upper')
    # print(SQL)
    print(parsed)




if __name__ == "__main__":
    main(sys.argv[1:])





    # SQL = """CREATE TABLE `activity_award_tmp` (`aat_id` bigint(20) NOT NULL AUTO_INCREMENT,`external_id` int(11) unsigned NOT NULL COMMENT 'PHP主键', `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',`money` bigint(20) DEFAULT '0' COMMENT '奖励金额',`rate` smallint(6) DEFAULT '0' COMMENT '奖励利率',`detail` varchar(512) NOT NULL DEFAULT '' COMMENT '详细信息',`type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0:特权本金;1:奖励利率',`date` date NOT NULL COMMENT '生效的时间',PRIMARY KEY (`aat_id`), KEY `date_u_id` (`date`,`u_id`)) ENGINE=InnoDB AUTO_INCREMENT=2042546240 DEFAULT CHARSET=utf8 COMMENT='用户奖励临时表';"""
    # SQL = """Select  * from `jd-java`.js left join c on c.a=jd.b where a=b;  INSERT INTO `activity_award_tmp` (`aat_id`, `external_id`, `u_id`, `money`, `rate`, `detail`, `type`, `date`)
# VALUES
#  (null, 1600835, 1593180, 0, 50, '[{\"rate\":\"50\",\"ac_id\":\"35\"}]', 1, '2018-12-03');"""
    # SQL = sqlparse.split(SQL)[0]
    # parsed = sqlparse.format(SQL, reindent=True, indent_width=2, keyword_case='upper')
#    parsed = sqlparse.parse(SQL)
#    for item in parsed[0].tokens:
#        print(type(item), item.ttype, item.value)
#     print(parsed)
