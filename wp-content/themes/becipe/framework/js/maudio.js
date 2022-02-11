function becipe_fn_maudio(_opt){
  var opt = {
    obj : _opt.obj ? _opt.obj : 'audio',
    fastStep : _opt.fastStep ? _opt.fastStep : 10
  }
  opt.tpl = '\
    <div class="becipe_fn_maudio">\
      <audio src="" initaudio="false"></audio>\
      <div class="audio-control">\
          <a href="javascript:;" class="fast-reverse"></a>\
          <a href="javascript:;" class="play"></a>\
          <a href="javascript:;" class="fast-forward"></a>\
          <div class="progress-bar">\
              <div class="progress-pass"></div>\
          </div>\
          <div class="time-keep">\
              <span class="current-time">00:00</span> / <span class="duration">00:00</span>\
          </div>\
          <a class="mute"></a>\
          <div class="volume-bar">\
              <div class="volume-pass"></div>\
          </div>\
      </div>\
    </div>'
  // var currentAudio,currentAudioBox

  var thisWindow = jQuery(opt.obj).parents(window)

  // 如果样式已经初始化，只要初始化事件
  if (!jQuery(opt.obj).parent('.becipe_fn_maudio').length || !jQuery(opt.obj).next('div.audio-control').length) {
    // 初始化所有音频
    window.tDuration = window.tDuration ? window.tDuration : {}
    jQuery(opt.obj).each(function(i){
      jQuery(this).before(opt.tpl)
      var thisBox = jQuery(this).prev('div.becipe_fn_maudio')
      var thisAudio = thisBox.children('audio')[0]
      thisAudio.src = jQuery(this).attr('src') || jQuery(this).children('source').attr('src')
      window.tDuration[opt.obj + thisAudio.src + '_' + i] = setInterval(function(){
        if(thisAudio.duration){
          thisBox.find('.time-keep .duration').text(timeFormat(thisAudio.duration))
          clearInterval(window.tDuration[opt.obj + thisAudio.src + '_' + i])
        }
      },100)
      jQuery(this).remove()
    })
  }


  function progressBar(audio,pgp){
    var p = 100*currentAudio.currentTime/currentAudio.duration
    currentAudioBox.find('.progress-pass').css({'width':p + '%'})
    // 计算当前时间
    currentAudioBox.find('.current-time').text(timeFormat(currentAudio.currentTime))
    // 播放结束
    if(currentAudio.currentTime >= currentAudio.duration){
      currentAudioBox.removeClass('playing')
      clearInterval(t)
    }
  }

  function bindAudioCtrl(){
    // 播放
    jQuery(thisWindow).find('.audio-control .play').off('click')
    jQuery(thisWindow).find('.audio-control .play').on('click', function(){
      var audioBox = jQuery(this).parent('.audio-control').parent('.becipe_fn_maudio')
      var audio = audioBox.children('audio')[0]
      if(audioBox.hasClass('playing')){
        audio.pause()
        audioBox.removeClass('playing')
      }else{
        // 停止其他语音播放
        jQuery(thisWindow).find('.playing').each(function(){
          jQuery(this).children('audio')[0].pause()
          jQuery(this).removeClass('playing')
        })
        audio.play()
        audioBox.addClass('playing')
        currentAudio = audio
        currentAudioBox = audioBox
        // 进度条
        window.t = window.setInterval(function(){
          progressBar()
        },500)
      }
    })
    // 快进
    jQuery(thisWindow).find('.audio-control .fast-reverse').off('click')
    jQuery(thisWindow).find('.audio-control .fast-reverse').on('click', function(){
      currentAudio.currentTime -= opt.fastStep
    })
    // 快退
    jQuery(thisWindow).find('.audio-control .fast-forward').off('click')
    jQuery(thisWindow).find('.audio-control .fast-forward').on('click', function(){
      currentAudio.currentTime += opt.fastStep
    })
    // 音量
    jQuery(thisWindow).find('.audio-control .volume-bar').off('click')
    jQuery(thisWindow).find('.audio-control .volume-bar').on('click', function(e){
      var audioBox = jQuery(this).parent('.audio-control').parent('.becipe_fn_maudio')
      var audio = audioBox.children('audio')[0]
      var p = e.offsetX / audioBox.find('.volume-bar').width()
      audioBox.find('.volume-pass').css({"width":p * 100 + '%'})
      audio.volume = p > 1 ? 1 : p
    })
    // 静音
    jQuery(thisWindow).find('.audio-control .mute').off('click')
    jQuery(thisWindow).find('.audio-control .mute').on('click', function(e){
      var audioBox = jQuery(this).parent('.audio-control').parent('.becipe_fn_maudio')
      var audio = audioBox.children('audio')[0]
      if(jQuery(this).hasClass('muted')){
        audio.muted = false
        jQuery(this).removeClass('muted')
      }else{
        audio.muted = true
        jQuery(this).addClass('muted')
      }
    })
    // 进度条
    jQuery(thisWindow).find('.audio-control .progress-bar').off('click')
    jQuery(thisWindow).find('.audio-control .progress-bar').on('click', function(e){
      var audioBox = jQuery(this).parent('.audio-control').parent('.becipe_fn_maudio')
      var audio = audioBox.children('audio')[0]
      var p = e.offsetX / audioBox.find('.progress-bar').width()
      audioBox.find('.progress-pass').css({"width":p * 100 + '%'})
      audio.currentTime = audio.duration * p
      // 同步一下本条音频的当前时间
      audioBox.find('.current-time').text(timeFormat(audio.currentTime))
    })
    // 如果音频遇到其他操作变更按钮状态
    jQuery(thisWindow).find('.becipe_fn_maudio audio').off('play')
    jQuery(thisWindow).find('.becipe_fn_maudio audio').on('play', function () {
      if (!jQuery(this).parent('.becipe_fn_maudio').hasClass('playing')) {
        jQuery(this).parent('.becipe_fn_maudio').addClass('playing')
      }
    })
    jQuery(thisWindow).find('.becipe_fn_maudio audio').off('pause')
    jQuery(thisWindow).find('.becipe_fn_maudio audio').on('pause', function () {
      if (jQuery(this).parent('.becipe_fn_maudio').hasClass('playing')) {
        jQuery(this).parent('.becipe_fn_maudio').removeClass('playing')
      }
    })

  }
  bindAudioCtrl()

  // 时间换算成“00:00”格式
  function timeFormat(sec){
    var m = parseInt(sec/60)
    var s = parseInt(sec%60)
    return (m < 10 ?  '0' + m : m)+ ':' + (s < 10 ?  '0' + s : s)
  }
}