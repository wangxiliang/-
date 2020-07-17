// 封装ajax请求  返回promise对象

class Request {
  request (params) {
    return new Promise(function(resolve, reject) {
      $.ajax({
        url: params.url,
        type:params.type||"GET",
        async:params.async||true,
        dataType: params.dataType||"json",
        timeout:params.timeout|| 4000,
        data: params.data || {},
        // processData:params.processData,
        // contentType:params.contentType,
        // crossDomain:params.crossDomain,
        // jsonpCallback:params.jsonpCallback,
        success: function(data){
          resolve(data);//pending--->resovled
        },
        error: function({responseJSON}){
          layer.msg(responseJSON.message || '服务器异常')
          reject(responseJSON);//pending--->rejected
        }
      })
    })
  }

  http_post(url, data) {
    return this.request({
      url,
      type: 'post',
      data
    }).then(res => {
      return res
    })
  }

  http_get(url, data) {
    return this.request({
      url,
      type: 'get',
      data
    }).then(res => {
      return res
    })
  }

}