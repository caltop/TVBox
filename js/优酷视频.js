var rule = {
    title:'优酷',
    host:'https://www.%79%6f%75%6b%75.com',
    homeUrl:'',
    searchUrl:'https://search.%79%6f%75%6b%75.com/api/search?pg=fypage&keyword=**',
    searchable:2,
    quickSearch:0,
    filterable:1,
    multi:1,
    // 分类链接fypage参数支持1个()表达式
    url:'/category/data?optionRefresh=1&pageNo=fypage&params=fyfilter',
    // url:'/category/data?pageNo=fypage&params=fyfilter',
    // filter_url:'&u=fyarea&s=fyyear={{fl.order}}',
    // filter_url:'{{fl|safe}}',
    filter_url:'{{fl}}',
    // filter_url:'{{fl}}',
    // filter_url:'{{fl}}',
    



    
    headers:{
        'User-Agent':'PC_UA',
        'Cookie':'cna=VvNvGX3e0ywCAavVEXlnA2bg; __ysuid=1626676228345Rl1; __ayft=1652434048647; __arycid=dm-1-00; __arcms=dm-1-00; __ayvstp=85; __arpvid=1667204023100cWWdgM-1667204023112; __ayscnt=10; __aypstp=60; isg=BBwcqxvvk3BxkWQGugbLpUSf7TrOlcC_U7GAj_YdfYfvQbzLHqYGT4Hgp6m5TvgX; tfstk=c3JOByYUH20ilVucLOhh0pCtE40lZfGc-PjLHLLfuX7SWNyAiQvkeMBsIw7PWDC..; l=eBQguS-PjdJFGJT-BOfwourza77OSIRA_uPzaNbMiOCPOb1B5UxfW6yHp4T6C3GVhsGJR3rp2umHBeYBqQd-nxvOF8qmSVDmn',
    },
    timeout:5000,
    class_name:'电视剧&电影&综艺&动漫&少儿&纪录片&文化&亲子&教育&搞笑&生活&体育&音乐&游戏',
    class_url:'电视剧&电影&综艺&动漫&少儿&纪录片&文化&亲子&教育&搞笑&生活&体育&音乐&游戏',
    limit:20,
    play_parse:true,
    // 手动调用解析请求json的url,此lazy不方便
    // lazy:'js:print(input);fetch_params.headers["user-agent"]=MOBILE_UA;let html=request(input);let rurl=html.match(/window\\.open\\(\'(.*?)\',/)[1];rurl=urlDeal(rurl);input={parse:1,url:rurl};',
    lazy:'js:input={parse:1,jx:1,url:input};',
    // 推荐:'.list_item;img&&alt;img&&src;a&&Text;a&&data-float',
    // 一级:'json:data.filterData.listData;title;img;subTitle;videoLink;summary',
    一级:'',
    一级:'js:let d=[];MY_FL.type=MY_CATE;let fl=stringify(MY_FL);fl=encodeUrl(fl);input=input.split("{")[0]+fl;if(MY_PAGE>1){let old_session=getItem("yk_session_"+MY_CATE,"{}");if(MY_PAGE===2){input=input.replace("optionRefresh=1","session="+encodeUrl(old_session))}else{input=input.replace("optionRefresh=1","session="+encodeUrl(old_session))}}let html=fetch(input,fetch_params);try{html=JSON.parse(html);let lists=html.data.filterData.listData;let session=html.data.filterData.session;session=stringify(session);if(session!==getItem("yk_session_"+MY_CATE,"{}")){setItem("yk_session_"+MY_CATE,session)}lists.forEach(function(it){let vid;if(it.videoLink.includes("id_")){vid=it.videoLink.split("id_")[1].split(".html")[0]}else{vid="msearch:"}d.push({title:it.title,img:it.img,desc:it.summary,url:"https://search.youku.com/api/search?appScene=show_episode&showIds="+vid,content:it.subTitle})})}catch(e){log("一级列表解析发生错误:"+e.message)}setResult(d);',
    二级:'',
    二级:'js:var d=[];VOD={};let html=request(input);let json=JSON.parse(html);if(/keyword/.test(input)){input="https://search.youku.com/api/search?appScene=show_episode&showIds="+json.pageComponentList[0].commonData.showId;json=JSON.parse(fetch(MY_URL,fetch_params))}let video_lists=json.serisesList;var name=json.sourceName;if(/优酷/.test(name)&&video_lists.length>0){let ourl="https://v.youku.com/v_show/id_"+video_lists[0].videoId+".html";let _img=video_lists[0].thumbUrl;let html=fetch(ourl,{headers:{Referer:"https://v.youku.com/","User-Agent":PC_UA}});let json=/__INITIAL_DATA__/.test(html)?html.split("window.__INITIAL_DATA__ =")[1].split(";")[0]:"{}";if(json==="{}"){log("触发了优酷人机验证");VOD.vod_remarks=ourl;VOD.vod_pic=_img;VOD.vod_name=video_lists[0].title.replace(/(\\d+)/g,"");VOD.vod_content="触发了优酷人机验证,本次未获取详情,但不影响播放("+ourl+")"}else{try{json=JSON.parse(json);let data=json.data.data;let data_extra=data.data.extra;let img=data_extra.showImgV;let model=json.data.model;let m=model.detail.data.nodes[0].nodes[0].nodes[0].data;let _type=m.showGenre;let _desc=m.updateInfo||m.subtitle;let JJ=m.desc;let _title=m.introTitle;VOD.vod_pic=img;VOD.vod_name=_title;VOD.vod_type=_type;VOD.vod_remarks=_desc;VOD.vod_content=JJ}catch(e){log("海报渲染发生错误:"+e.message);print(json);VOD.vod_remarks=name}}}if(!/优酷/.test(name)){VOD.vod_content="非自家播放源,暂无视频简介及海报";VOD.vod_remarks=name}function adhead(url){return urlencode(url)}play_url=play_url.replace("&play_url=","&type=json&play_url=");video_lists.forEach(function(it){let url="https://v.youku.com/v_show/id_"+it.videoId+".html";if(it.thumbUrl){d.push({desc:it.showVideoStage?it.showVideoStage.replace("期","集"):it.displayName,pic_url:it.thumbUrl,title:it.title,url:play_url+adhead(url)})}else if(name!=="优酷"){d.push({title:it.displayName?it.displayName:it.title,url:play_url+adhead(it.url)})}});VOD.vod_play_from=name;VOD.vod_play_url=d.map(function(it){return it.title+"$"+it.url}).join("#");',
    搜索:'',
    搜索:'js:var d=[];let html=request(input);let json=JSON.parse(html);json.pageComponentList.forEach(function(it){if(it.hasOwnProperty("commonData")){it=it.commonData;d.push({title:it.titleDTO.displayName,img:it.posterDTO.vThumbUrl,desc:it.stripeBottom,content:it.updateNotice+" "+it.feature,url:"https://search.youku.com/api/search?appScene=show_episode&showIds="+it.showId+"&appCaller=h5"})}});setResult(d);',
}