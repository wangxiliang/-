var ut = {
  // 数据成功响应自跳转
  sucDoPage(msg, url) {
    layer.msg(msg)
    setTimeout(() => {
      location.href = url
    }, 1500)
  },
  // 弹出loading框
  showLoading(show) {
    if(show) {
      layer.load(0, {
        shade: [0.2, '#000']
      })
    }else {
      layer.closeAll('loading')
    }

  }
}