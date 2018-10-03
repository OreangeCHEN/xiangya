var app = getApp();
var j = 0;
var canUseReachBottom = true;//触底函数控制变量
Page({
  data: {
    pageItems: [{
        page_id: 0,
        page_name: "热点新闻",
        index: 0,
        page: 2,
        part: [],
        banner: [],
        article: []
      },
      {
        page_id: 1,
        page_name: "妇婴保健",
        index: 0,
        page: 2,
        part: [],
        banner: [],
        article: []
      },
      {
        page_id: 2,
        page_name: "疾病防治",
        index: 0,
        page: 2,
        part: [],
        banner: [],
        article: []
      },
      {
        page_id: 3,
        page_name: "饮食保健",
        index: 0,
        page: 2,
        part: [],
        banner: [],
        article: []
      },
      {
        page_id: 4,
        page_name: "心理健康",
        index: 0,
        page: 2,
        part: [],
        banner: [],
        article: []
      },
    ],
    winHeight: "", //窗口高度
    currentTab: 0, //预设当前项的值
    scrollLeft: 0, //tab标题的滚动条位置
    preIndex: 0,
    times: 0,
    newArray: 0,
    showModal: true,
    loading: false,
  },
  getBanner: function(now) {
    var that = this;
    wx.request({
      url: 'http://139.199.211.244/api/v1/banner/' + now,
      success: function(res) {
        that.data.pageItems[now - 1].banner = res.data
        var i = now - 1
        var banner = "pageItems[" + i + "].banner"
        that.setData({
          [banner]: res.data,
        })
      },
      fail: function() {

      },
      complete: function() {}
    });
  },
  // 滚动切换标签样式
  switchTab: function(e) {
    if (this.data.currentTab == e.detail.current) {
      return false;
    } else {
      if (e.detail.current == this.data.preIndex) {
        var i = this.data.times + 1;
        this.setData({
          times: i
        })
        if (this.data.times > 3) {
          this.setData({
            currentTab: 0,
            preIndex: 0,
            times: 0
          })
        } else {
          this.setData({
            preIndex: this.data.currentTab,
            currentTab: e.detail.current,
          });
        }
      } else {
        this.setData({
          preIndex: this.data.currentTab,
          currentTab: e.detail.current,
          times: 0
        });
      }
    }
    this.checkCor();
  },
  // 点击标题切换当前页时改变样式
  swichNav: function(e) {
    var cur = e.target.dataset.current;
    if (this.data.currentTaB == cur) {
      return false;
    } else {
      this.setData({
        currentTab: cur,
      })
    }
    this.checkCor();
  },
  switchPartTab: function(e) {
    var cur = e.target.dataset.id;
    if (this.data.pageItems[this.data.currentTab].index == cur) {
      return false;
    } else {
      var i = this.data.currentTab
      var index = "pageItems[" + i + "].index"
      this.setData({
        [index]: cur
      })
    }
  },
  //判断当前滚动超过一屏时，设置tab标题滚动条。
  checkCor: function() {
    if (this.data.currentTab > 2) {
      this.setData({
        scrollLeft: 300
      })
    } else {
      this.setData({
        scrollLeft: 0
      })
    }
  },
  stopTouchMove: function() {
    return false;
  },
  detail: function(event) {
    var articleId = event.currentTarget.dataset.articleId
    var articleTitle = event.currentTarget.dataset.articleTitle
    var articleMain = event.currentTarget.dataset.articleMain
    var articleAuthor = event.currentTarget.dataset.articleAuthor
    var articleTime = event.currentTarget.dataset.articleTime
    wx.setStorageSync("title", articleTitle)
    wx.setStorageSync("main", articleMain)
    wx.navigateTo({
      url: '/pages/article/article?id=' + articleId + "&time=" + articleTime + "&author=" + articleAuthor
    })
  },

  preventTouchMove: function() {
    return false;
  },
  //上拉触底渲染
  loadMore: function() {
    if (!canUseReachBottom) return;//如果触底函数不可用，则不调用网络请求数据
    canUseReachBottom = false;
    wx.showNavigationBarLoading();
    var a = '';
    var d = this.data.currentTab
    switch (d) {
      case 0:
        a = 'rdxw';
        break;
      case 1:
        a = 'fybj';
        break;
      case 2:
        a = 'jbfz';
        break;
      case 3:
        a = 'ysbj';
        break;
      case 4:
        a = 'xljk';
        break;
      default:
        break;
    }
    var i = this.data.pageItems[this.data.currentTab].page
    console.log(i)
    var that = this
    wx.request({
      url: 'http://139.199.211.244/api/Article/read_by_kind?kind=' + a + '&page=' + i,
      success: function(res) {
        if (res.data.data.length != 0) {
          var article_current = res.data.data
          var n = "pageItems[" + that.data.currentTab + "].page"
          that.setData({
            [n]: ++i
          })
            var length = that.data.pageItems[that.data.currentTab].article.length + article_current.length - 1
          for (var k = 0; k < article_current.length; k++) {
            var article = "pageItems[" + that.data.currentTab + "].article[" + length + "]"
            that.setData({
              [article]: article_current[k],
            })
            length--;
          }
        } else {
          var article_delete = "pageItems[" + that.data.currentTab + "].article"
          var same = 0
          var lenth = that.data.pageItems[that.data.currentTab].article.length
          for (var a1 = 0; a1 < lenth; a1++) {
            for (var a2 = 0; a2 < lenth; a2++) {
              if (a1 != a2) {
                if (that.data.pageItems[that.data.currentTab].article[a1].id == that.data.pageItems[that.data.currentTab].article[a2].id)
                  same = 1
              }
            }
          }
          var lenth2 = that.data.pageItems[that.data.currentTab].article.length
          if (i == 2 && same == 1) {
            that.setData({
              [article_delete]: null
            })
            wx.request({
              url: 'http://139.199.211.244/api/Article/read_by_kind?kind=' + a + '&page=1',
              success: function(res) {
                var article_current = res.data.data
                var length = article_current.length - 1
                for (var i = 0; i < article_current.length; i++) {
                  var article = "pageItems[" + 0 + "].article[" + length + "]"
                  that.setData({
                    [article]: article_current[i]
                  })
                  length--;
                }
              }
            })


          }
          that.setData({
            loading: true
          })
          setTimeout(() => that.setData({
            loading: false
          }), 2000)
        }
      },
      fail: function() {
        // fail
      },
      complete: function() {
        // complete
        wx.hideNavigationBarLoading() //完成停止加载
        wx.stopPullDownRefresh() //停止下拉刷新
        canUseReachBottom = true
        console.log(that.data.pageItems[that.data.currentTab].article)
        that.checksame
      }


    })

  },

  go: function() {
    this.setData({
      showModal: false
    })
  },
  // 预加载
  onLoad: function(options) {
    var that = this;
    //  高度自适应
    wx.getSystemInfo({
      success: function(res) {
        var clientHeight = res.windowHeight,
          clientWidth = res.windowWidth,
          rpxR = 750 / clientWidth;
        var calc = clientHeight * rpxR - 180;
        that.setData({
          winHeight: calc
        });
      }
    });
    this.setData({})
    var that = this;
    for (var i = 0; i < 5; i++) {
      this.getBanner(i + 1);
    }
    wx.request({
      url: 'http://139.199.211.244/api/Article/read_by_kind?kind=rdxw&page=1',
      success: function(res) {
        var article_current = res.data.data
        var length = article_current.length - 1
        for (var i = 0; i < article_current.length; i++) {
          var article = "pageItems[" + 0 + "].article[" + length + "]"
          that.setData({
            [article]: article_current[i]
          })
          length--;
        }
      },
      fail: function() {

      },
      complete: function() {}
    });
    wx.request({
      url: 'http://139.199.211.244/api/Article/read_by_kind?kind=fybj&page=1',
      success: function(res) {
        var article_current = res.data.data
        var length = article_current.length - 1
        for (var i = 0; i < article_current.length; i++) {
          var article = "pageItems[" + 1 + "].article[" + length + "]"
          that.setData({
            [article]: article_current[i]
          })
          length--;
        }
      },
      fail: function() {

      },
      complete: function() {}
    });
    wx.request({
      url: 'http://139.199.211.244/api/Article/read_by_kind?kind=jbfz&page=1',
      success: function(res) {
        var article_current = res.data.data
        var length = article_current.length - 1
        for (var i = 0; i < article_current.length; i++) {
          var article = "pageItems[" + 2 + "].article[" + length + "]"
          that.setData({
            [article]: article_current[i]
          })
          length--;
        }
        that.setData({
          showModal: false
        })
      },
      fail: function() {

      },
      complete: function() {
        wx.hideNavigationBarLoading()
        wx.stopPullDownRefresh()
      }
    });
    wx.request({
      url: 'http://139.199.211.244/api/Article/read_by_kind?kind=ysbj&page=1',
      success: function(res) {
        var article_current = res.data.data
        var length = article_current.length - 1
        for (var i = 0; i < article_current.length; i++) {
          var article = "pageItems[" + 3 + "].article[" + length + "]"
          that.setData({
            [article]: article_current[i]
          })
          length--;
        }
        that.setData({
          showModal: false
        })
      },
      fail: function() {

      },
      complete: function() {}
    });
    wx.request({
      url: 'http://139.199.211.244/api/Article/read_by_kind?kind=xljk&page=1',
      success: function(res) {
        var article_current = res.data.data
        var length = article_current.length - 1
        for (var i = 0; i < article_current.length; i++) {
          var article = "pageItems[" + 4 + "].article[" + length + "]"
          that.setData({
            [article]: article_current[i]
          })
          length--;
        }
        that.setData({
          showModal: false
        })
      },
      fail: function() {

      },
      complete: function() {}
    });

  },
  footerTap: app.footerTap,
  checksame: function () {
    var that = this
    var length = that.data.pageItems[that.data.currentTab].article.length
    for(var i = 0 ; i < length ; i++)
    {
      for(var k = 0 ; k <length ; k++)
      {
        if(i != k){
          if (that.data.pageItems[that.data.currentTab].article[i].id == that.data.pageItems[that.data.currentTab].article[k].id){
            wx.showNavigationBarLoading()
            this.onLoad()
          }
        }
      }
    }
  },
  refresh: function() {
    wx.showNavigationBarLoading()
    this.onLoad()

  }
})