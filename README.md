# 简单健康咨询系统Web API


## 接口使用方法

直接用http访问即可

## 索引

* [注册](#注册)
* [登陆](#登陆)
* [提交咨询](#提交咨询)
* [删除咨询](#删除咨询)
* [提交评论](#提交评论)
* [删除评论](#删除评论)
* [列出咨询](#列出咨询)
* [查看指定咨询](#查看指定咨询)


### 注册
域名/?ac=user&do=register&username=test1&password=123 
	
#### 请求参数
	ac : user, 固定参数
	do : register , 固定参数
	username : 用户名 
	password : 密码
#### 返回字段
	* code -- 错误代码，0代表成功，1代表失败
	* msg -- 错误信息， do_success 代表成功
	* data -- json数组，操作成功后返回的数据

#### 样例
	URL:
		localhost/zx/?ac=user&do=register&username=test1&password=123
	GET:
		ac : user
		do : register
		username : test1
		password : 123
	Response:
	-----------------------------------------------------
	{"code":0,"msg":"do_success","data":[]}

------
### 登陆
域名/?ac=user&do=login&username=test1&password=123 

#### 请求参数
	ac : user , 固定参数
	do : login , 固定参数
	username : 用户名 
	password : 密码
	
#### 返回字段
	* code -- 错误代码，0代表成功，1代表失败
	* msg -- 错误信息， do_success 代表成功
	* data -- json数组，操作成功后返回的数据
		* auth -- API密钥, 每次调用接口，需要提供此key以验证用户
	

#### 样例
	URL:
		localhost/zx/?ac=user&do=login&username=test1&password=123
	GET:
		ac : user
		do : login
		username : test1
		password : 123
	Response:
	-----------------------------------------------------
	{"code":0,"msg":"do_success","data":{"auth":"3d275GwMZHITUMWjF0gNm4jN%2Fcb9fSwYXaEMLfbcxROltg"}}

------
### 提交咨询
域名/?ac=submit&do=zixun&auth=3d275GwMZHITUMWjF0gNm4jN%2Fcb9fSwYXaEMLfbcxROltg&op=add

#### 请求参数
	GET:
		ac : submit, 固定参数
		do : zixun, 固定参数
		op : add, 固定参数
		auth : API密钥
	POST:
		subject : 咨询标题
		message : 咨询正文
	
#### 返回字段
	* code -- 错误代码，0代表成功，1代表失败
	* msg -- 错误信息， do_success 代表成功
	* data -- json数组，操作成功后返回的数据
		* zid -- 新咨询的ID
	

#### 样例
	URL:
		localhost/zx/?ac=submit&do=zixun&auth=3d275GwMZHITUMWjF0gNm4jN%2Fcb9fSwYXaEMLfbcxROltg&op=add
	GET:
		ac : submit
		do : zixun
		auth : 3d275GwMZHITUMWjF0gNm4jN%2Fcb9fSwYXaEMLfbcxROltg
		op : add
	POST:
		subject : 咨询标题
		message : 咨询正文
	Response:
	-----------------------------------------------------
	{"code":0,"msg":"do_success","data":{"zid":23}}
	
	
	
------
### 删除咨询

域名/?ac=submit&do=zixun&auth=3d275GwMZHITUMWjF0gNm4jN%2Fcb9fSwYXaEMLfbcxROltg&op=del&zid=1

#### 请求参数
	GET:
		ac : submit, 固定参数
		do : zixun, 固定参数
		op : del, 固定参数
		auth : API密钥
		zid : 要删除的咨询的ID
	
#### 返回字段
	* code -- 错误代码，0代表成功，1代表失败
	* msg -- 错误信息， do_success 代表成功
	* data -- json数组，操作成功后返回的数据	

#### 样例
	URL:
		localhost/zx/?ac=submit&do=zixun&auth=3d275GwMZHITUMWjF0gNm4jN%2Fcb9fSwYXaEMLfbcxROltg&op=del&zid=1
	GET:
		ac : submit
		do : zixun
		auth : 3d275GwMZHITUMWjF0gNm4jN%2Fcb9fSwYXaEMLfbcxROltg
		op : del
		zid : 1
	Response:
	-----------------------------------------------------
	{"code":1,"msg":"zixun_not_exist","data":[]}



------
### 提交评论
域名/?ac=submit&do=comment&auth=3d275GwMZHITUMWjF0gNm4jN%2Fcb9fSwYXaEMLfbcxROltg&op=add&zid=2

#### 请求参数
	GET:
		ac : submit, 固定参数
		do : comment, 固定参数
		op : add, 固定参数
		auth : API密钥
		zid : 被评论的咨询的ID
	POST:
		message : 评论正文
	
#### 返回字段
	* code -- 错误代码，0代表成功，1代表失败
	* msg -- 错误信息， do_success 代表成功
	* data -- json数组，操作成功后返回的数据
		* zid -- 新咨询的ID
	

#### 样例
	URL:
		localhost/zx/?ac=submit&do=comment&auth=3d275GwMZHITUMWjF0gNm4jN%2Fcb9fSwYXaEMLfbcxROltg&op=add&zid=2
	GET:
		ac : submit
		do : comment
		auth : 3d275GwMZHITUMWjF0gNm4jN%2Fcb9fSwYXaEMLfbcxROltg
		op : add
		zid : 2
	POST:
		message : 评论内容
	Response:
	-----------------------------------------------------
	{"code":0,"msg":"do_success","data":{"cid":24}}
	
------
### 删除评论

域名/?ac=submit&do=comment&auth=3d275GwMZHITUMWjF0gNm4jN%2Fcb9fSwYXaEMLfbcxROltg&op=del&cid=1

#### 请求参数
	GET:
		ac : submit, 固定参数
		do : comment, 固定参数
		op : del, 固定参数
		auth : API密钥
		cid : 要删除的评论的ID
	
#### 返回字段
	* code -- 错误代码，0代表成功，1代表失败
	* msg -- 错误信息， do_success 代表成功
	* data -- json数组，操作成功后返回的数据	

#### 样例
	
	URL:
		localhost/zx/?ac=submit&do=comment&auth=3d275GwMZHITUMWjF0gNm4jN%2Fcb9fSwYXaEMLfbcxROltg&op=del&cid=1
	GET:
		ac : submit
		do : comment
		auth : 3d275GwMZHITUMWjF0gNm4jN%2Fcb9fSwYXaEMLfbcxROltg
		op : del
		cid : 1
	Response:
	-----------------------------------------------------
	{"code":0,"msg":"do_success","data":[]}

------
### 列出咨询

域名/?ac=view&do=listzx&start=16&perpage=5

#### 请求参数
	GET:
		ac : view, 固定参数
		do : listzx, 固定参数
		start : 要列出的咨询的开始位置，非必需参数，默认为0
		perpage : 要列出的咨询的数目，非必需参数，默认为10
	
#### 返回字段
	* code -- 错误代码，0代表成功，1代表失败
	* msg -- 错误信息， do_success 代表成功
	* data -- json数组，操作成功后返回的数据
		zixun -- json数组
			total -- 咨询的总数目
			count -- 当前返回的咨询的数目
			list -- 当前返回的咨询列表
				zid -- 咨询的ID
				uid -- 咨询发布者的ID
				subject -- 咨询标题
				dateline -- 时间戳
				message -- 咨询正文
				username -- 咨询发布者的用户名

#### 样例

	URL:
		localhost/zx/?ac=view&do=listzx&start=16&perpage=5
	GET:
		ac : view
		do : listzx
		start : 16
		perpage : 5
	Response:
	-----------------------------------------------------
	{
		"code":0,
		"msg":"do_success",
		"data":{
			"zixun":{
				"total":23,
				"count":5,
				"list":[
					{
						"zid":8,
						"uid":1,
						"subject":"咨询1",
						"dateline":1451454442,
						"message":"咨询1正文",
						"username":"test1"
					},
					{
						"zid":7,
						"uid":1,
						"subject":"咨询2",
						"dateline":1451454441,
						"message":"咨询2正文",
						"username":"test1"
					},
					{
						"zid":6,
						"uid":1,
						"subject":"咨询3",
						"dateline":1451454045,
						"message":"咨询3正文",
						"username":"test1"
					},
					{
						"zid":5,
						"uid":1,
						"subject":"咨询4",
						"dateline":1451454044,
						"message":"咨询4正文",
						"username":"test1"
					},
					{
						"zid":4,
						"uid":1,
						"subject":"咨询5",
						"dateline":1451454043,
						"message":"咨询5正文",
						"username":"test1"
					}
				]
			}
		}
	}

------
### 查看指定咨询

域名/?ac=view&do=showzx&zid=2&start=16&perpage=5

#### 请求参数
	GET:
		ac : view, 固定参数
		do : showzx, 固定参数
		zid : 咨询ID
		start : 要列出的评论开始位置，非必需参数，默认为0
		perpage : 要列出的评论数目，非必需参数，默认为30
	
#### 返回字段
	* code -- 错误代码，0代表成功，1代表失败
	* msg -- 错误信息， do_success 代表成功
	* data -- json数组，操作成功后返回的数据
		zixun -- json数组
			zid -- 咨询的ID
			uid -- 咨询发布者的ID
			subject -- 咨询标题
			dateline -- 时间戳
			message -- 咨询正文
			username -- 咨询发布者的用户名
			total -- 当前咨询下的评论的总数目
			count -- 当前返回的评论的数目
			comment -- 当前咨询下的评论
				cid -- 评论的ID
				zid -- 当前评论所属咨询的ID
				uid -- 评论发表者的ID
				username -- 评论发表者的用户名
				message -- 评论内容

#### 样例
	URL:
		localhost/zx/?ac=view&do=showzx&zid=2&start=16&perpage=5
	GET:
		ac : view
		do : showzx
		zid : 2
		start : 16
		perpage : 5
	Response:
	-----------------------------------------------------
	{
		"code":0,
		"msg":"do_success",
		"data":{
			"zixun":{
				"zid":2,
				"uid":1,
				"subject":"咨询2",
				"dateline":1451453961,
				"message":"咨询正文",
				"username":"test1",
				"total":21,
				"count":5,
				"comment":[
					{
						"cid":20,
						"zid":2,
						"uid":1,
						"message":"评论1",
						"username":"test1"
					},
					{
						"cid":21,
						"zid":2,
						"uid":1,
						"message":"评论2",
						"username":"test1"
					},
					{
						"cid":22,
						"zid":2,
						"uid":1,
						"message":"评论3",
						"username":"test1"
					},
					{
						"cid":23,
						"zid":2,
						"uid":1,
						"message":"评论4",
						"username":"test1"
					},
					{
						"cid":24,
						"zid":2,
						"uid":1,
						"message":"评论5",
						"username":"test1"
					}
				]
			}
		}
	}
