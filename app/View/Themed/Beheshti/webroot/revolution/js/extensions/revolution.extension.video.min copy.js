/********************************************
 * REVOLUTION 5.1 EXTENSION - VIDEO FUNCTIONS
 * @version: 1.2.1 (26.11.2015)
 * @requires jquery.themepunch.revolution.js
 * @author ThemePunch
 *********************************************/
!(function (e) {
  function t(e) {
    return void 0 == e
      ? -1
      : jQuery.isNumeric(e)
      ? e
      : e.split(":").length > 1
      ? 60 * parseInt(e.split(":")[0], 0) + parseInt(e.split(":")[1], 0)
      : e;
  }
  var a = jQuery.fn.revolution,
    i = a.is_mobile();
  jQuery.extend(!0, a, {
    resetVideo: function (e, d) {
      switch (e.data("videotype")) {
        case "youtube":
          e.data("player");
          try {
            if ("on" == e.data("forcerewind") && !i) {
              var o = t(e.data("videostartat"));
              (o = -1 == o ? 0 : o),
                void 0 != e.data("player") &&
                  (e.data("player").seekTo(o), e.data("player").pauseVideo());
            }
          } catch (r) {}
          0 == e.find(".tp-videoposter").length &&
            punchgs.TweenLite.to(e.find("iframe"), 0.3, {
              autoAlpha: 1,
              display: "block",
              ease: punchgs.Power3.easeInOut,
            });
          break;
        case "vimeo":
          var n = $f(e.find("iframe").attr("id"));
          try {
            if ("on" == e.data("forcerewind") && !i) {
              var o = t(e.data("videostartat"));
              (o = -1 == o ? 0 : o), n.api("seekTo", o), n.api("pause");
            }
          } catch (r) {}
          0 == e.find(".tp-videoposter").length &&
            punchgs.TweenLite.to(e.find("iframe"), 0.3, {
              autoAlpha: 1,
              display: "block",
              ease: punchgs.Power3.easeInOut,
            });
          break;
        case "html5":
          if (i && 1 == e.data("disablevideoonmobile")) return !1;
          var s = e.find("video"),
            l = s[0];
          if (
            (punchgs.TweenLite.to(s, 0.3, {
              autoAlpha: 1,
              display: "block",
              ease: punchgs.Power3.easeInOut,
            }),
            "on" == e.data("forcerewind") && !e.hasClass("videoisplaying"))
          )
            try {
              var o = t(e.data("videostartat"));
              l.currentTime = -1 == o ? 0 : o;
            } catch (r) {}
          ("mute" == e.data("volume") ||
            a.lastToggleState(e.data("videomutetoggledby"))) &&
            (l.muted = !0);
      }
    },
    isVideoMuted: function (e, t) {
      var a = !1;
      switch (e.data("videotype")) {
        case "youtube":
          try {
            var i = e.data("player");
            a = i.isMuted();
          } catch (d) {}
          break;
        case "vimeo":
          try {
            $f(e.find("iframe").attr("id"));
            "mute" == e.data("volume") && (a = !0);
          } catch (d) {}
          break;
        case "html5":
          var o = e.find("video"),
            r = o[0];
          "mute" == e.data("volume") && (r.muted = !0);
      }
      return a;
    },
    muteVideo: function (e, t) {
      switch (e.data("videotype")) {
        case "youtube":
          try {
            var a = e.data("player");
            a.mute();
          } catch (i) {}
          break;
        case "vimeo":
          try {
            var d = $f(e.find("iframe").attr("id"));
            e.data("volume", "mute"), d.api("setVolume", 0);
          } catch (i) {}
          break;
        case "html5":
          var o = e.find("video"),
            r = o[0];
          r.muted = !0;
      }
    },
    unMuteVideo: function (e, t) {
      switch (e.data("videotype")) {
        case "youtube":
          try {
            var a = e.data("player");
            a.unMute();
          } catch (i) {}
          break;
        case "vimeo":
          try {
            var d = $f(e.find("iframe").attr("id"));
            e.data("volume", "1"), d.api("setVolume", 1);
          } catch (i) {}
          break;
        case "html5":
          var o = e.find("video"),
            r = o[0];
          r.muted = !1;
      }
    },
    stopVideo: function (e, t) {
      switch (e.data("videotype")) {
        case "youtube":
          try {
            var a = e.data("player");
            a.pauseVideo();
          } catch (i) {}
          break;
        case "vimeo":
          try {
            var d = $f(e.find("iframe").attr("id"));
            d.api("pause");
          } catch (i) {}
          break;
        case "html5":
          var o = e.find("video"),
            r = o[0];
          r.pause();
      }
    },
    playVideo: function (e, o) {
      switch ((clearTimeout(e.data("videoplaywait")), e.data("videotype"))) {
        case "youtube":
          if (0 == e.find("iframe").length)
            e.append(e.data("videomarkup")), r(e, o, !0);
          else if (void 0 != e.data("player").playVideo) {
            var n = t(e.data("videostartat")),
              s = e.data("player").getCurrentTime();
            1 == e.data("nextslideatend-triggered") &&
              ((s = -1), e.data("nextslideatend-triggered", 0)),
              -1 != n && n > s && e.data("player").seekTo(n),
              e.data("player").playVideo();
          } else
            e.data(
              "videoplaywait",
              setTimeout(function () {
                a.playVideo(e, o);
              }, 50)
            );
          break;
        case "vimeo":
          if (0 == e.find("iframe").length)
            e.append(e.data("videomarkup")), r(e, o, !0);
          else if (e.hasClass("rs-apiready")) {
            var l = e.find("iframe").attr("id"),
              p = $f(l);
            void 0 == p.api("play")
              ? e.data(
                  "videoplaywait",
                  setTimeout(function () {
                    a.playVideo(e, o);
                  }, 50)
                )
              : setTimeout(function () {
                  p.api("play");
                  var a = t(e.data("videostartat")),
                    i = e.data("currenttime");
                  1 == e.data("nextslideatend-triggered") &&
                    ((i = -1), e.data("nextslideatend-triggered", 0)),
                    -1 != a && a > i && p.api("seekTo", a);
                }, 510);
          } else
            e.data(
              "videoplaywait",
              setTimeout(function () {
                a.playVideo(e, o);
              }, 50)
            );
          break;
        case "html5":
          if (i && 1 == e.data("disablevideoonmobile")) return !1;
          var v = e.find("video"),
            u = v[0],
            c = v.parent();
          if (1 != c.data("metaloaded"))
            d(
              u,
              "loadedmetadata",
              (function (e) {
                a.resetVideo(e, o), u.play();
                var i = t(e.data("videostartat")),
                  d = u.currentTime;
                1 == e.data("nextslideatend-triggered") &&
                  ((d = -1), e.data("nextslideatend-triggered", 0)),
                  -1 != i && i > d && (u.currentTime = i);
              })(e)
            );
          else {
            u.play();
            var n = t(e.data("videostartat")),
              s = u.currentTime;
            1 == e.data("nextslideatend-triggered") &&
              ((s = -1), e.data("nextslideatend-triggered", 0)),
              -1 != n && n > s && (u.currentTime = n);
          }
      }
    },
    isVideoPlaying: function (e, t) {
      var a = !1;
      return (
        void 0 != t.playingvideos &&
          jQuery.each(t.playingvideos, function (t, i) {
            e.attr("id") == i.attr("id") && (a = !0);
          }),
        a
      );
    },
    prepareCoveredVideo: function (e, t, a) {
      var i = a.find("iframe, video"),
        d = e.split(":")[0],
        o = e.split(":")[1],
        r = a.closest(".tp-revslider-slidesli"),
        n = r.width() / r.height(),
        s = d / o,
        l = (n / s) * 100,
        p = (s / n) * 100;
      n > s
        ? punchgs.TweenLite.to(i, 0.001, {
            height: l + "%",
            width: "100%",
            top: -(l - 100) / 2 + "%",
            left: "0px",
            position: "absolute",
          })
        : punchgs.TweenLite.to(i, 0.001, {
            width: p + "%",
            height: "100%",
            left: -(p - 100) / 2 + "%",
            top: "0px",
            position: "absolute",
          });
    },
    checkVideoApis: function (e, t, a) {
      var i = "https:" === location.protocol ? "https" : "http";
      if (
        ((void 0 != e.data("ytid") ||
          (e.find("iframe").length > 0 &&
            e.find("iframe").attr("src").toLowerCase().indexOf("youtube") >
              0)) &&
          (t.youtubeapineeded = !0),
        (void 0 != e.data("ytid") ||
          (e.find("iframe").length > 0 &&
            e.find("iframe").attr("src").toLowerCase().indexOf("youtube") >
              0)) &&
          0 == a.addedyt)
      ) {
        (t.youtubestarttime = jQuery.now()), (a.addedyt = 1);
        var d = document.createElement("script");
        d.src = "https://www.youtube.com/iframe_api";
        var o = document.getElementsByTagName("script")[0],
          r = !0;
        jQuery("head")
          .find("*")
          .each(function () {
            "https://www.youtube.com/iframe_api" == jQuery(this).attr("src") &&
              (r = !1);
          }),
          r && o.parentNode.insertBefore(d, o);
      }
      if (
        ((void 0 != e.data("vimeoid") ||
          (e.find("iframe").length > 0 &&
            e.find("iframe").attr("src").toLowerCase().indexOf("vimeo") > 0)) &&
          (t.vimeoapineeded = !0),
        (void 0 != e.data("vimeoid") ||
          (e.find("iframe").length > 0 &&
            e.find("iframe").attr("src").toLowerCase().indexOf("vimeo") > 0)) &&
          0 == a.addedvim)
      ) {
        (t.vimeostarttime = jQuery.now()), (a.addedvim = 1);
        var n = document.createElement("script"),
          o = document.getElementsByTagName("script")[0],
          r = !0;
        (n.src = i + "://f.vimeocdn.com/js/froogaloop2.min.js"),
          jQuery("head")
            .find("*")
            .each(function () {
              jQuery(this).attr("src") ==
                i + "://a.vimeocdn.com/js/froogaloop2.min.js" && (r = !1);
            }),
          r && o.parentNode.insertBefore(n, o);
      }
      return a;
    },
    manageVideoLayer: function (e, o, s, l) {
      var p = e.data("videoattributes"),
        v = e.data("ytid"),
        u = e.data("vimeoid"),
        c = e.data("videpreload"),
        g = e.data("videomp4"),
        f = e.data("videowebm"),
        y = e.data("videoogv"),
        m = e.data("allowfullscreenvideo"),
        h = e.data("videocontrols"),
        b = "http",
        w =
          "loop" == e.data("videoloop")
            ? "loop"
            : "loopandnoslidestop" == e.data("videoloop")
            ? "loop"
            : "",
        T =
          void 0 != g || void 0 != f
            ? "html5"
            : void 0 != v && String(v).length > 1
            ? "youtube"
            : void 0 != u && String(u).length > 1
            ? "vimeo"
            : "none",
        k =
          "html5" == T && 0 == e.find("video").length
            ? "html5"
            : "youtube" == T && 0 == e.find("iframe").length
            ? "youtube"
            : "vimeo" == T && 0 == e.find("iframe").length
            ? "vimeo"
            : "none";
      switch ((e.data("videotype", T), k)) {
        case "html5":
          "controls" != h && (h = "");
          var x =
            '<video style="object-fit:cover;background-size:cover;visible:hidden;width:100%; height:100%" class="" ' +
            w +
            ' preload="' +
            c +
            '">';
          void 0 != f &&
            "firefox" == a.get_browser().toLowerCase() &&
            (x = x + '<source src="' + f + '" type="video/webm" />'),
            void 0 != g &&
              (x = x + '<source src="' + g + '" type="video/mp4" />'),
            void 0 != y &&
              (x = x + '<source src="' + y + '" type="video/ogg" />'),
            (x += "</video>");
          var L = "";
          ("true" === m || m === !0) &&
            (L =
              '<div class="tp-video-button-wrap"><button  type="button" class="tp-video-button tp-vid-full-screen">Full-Screen</button></div>'),
            "controls" == h &&
              (x +=
                '<div class="tp-video-controls"><div class="tp-video-button-wrap"><button type="button" class="tp-video-button tp-vid-play-pause">Play</button></div><div class="tp-video-seek-bar-wrap"><input  type="range" class="tp-seek-bar" value="0"></div><div class="tp-video-button-wrap"><button  type="button" class="tp-video-button tp-vid-mute">Ohne Ton</button></div><div class="tp-video-vol-bar-wrap"><input  type="range" class="tp-volume-bar" min="0" max="1" step="0.1" value="1"></div>' +
                L +
                "</div>"),
            e.data("videomarkup", x),
            e.append(x),
            ((i && 1 == e.data("disablevideoonmobile")) || a.isIE(8)) &&
              e.find("video").remove(),
            e.find("video").each(function (t) {
              var i = this,
                r = jQuery(this);
              r.parent().hasClass("html5vid") ||
                r.wrap(
                  '<div class="html5vid" style="position:relative;top:0px;left:0px;width:100%;height:100%; overflow:hidden;"></div>'
                );
              var s = r.parent();
              1 != s.data("metaloaded") &&
                d(
                  i,
                  "loadedmetadata",
                  (function (e) {
                    n(e, o), a.resetVideo(e, o);
                  })(e)
                );
            });
          break;
        case "youtube":
          (b = "http"),
            "https:" === location.protocol && (b = "https"),
            "none" == h &&
              ((p = p.replace("controls=1", "controls=0")),
              -1 == p.toLowerCase().indexOf("controls") &&
                (p += "&controls=0"));
          var V = t(e.data("videostartat")),
            P = t(e.data("videoendat"));
          -1 != V && (p = p + "&start=" + V), -1 != P && (p = p + "&end=" + P);
          var I = p.split("origin=" + b + "://"),
            C = "";
          I.length > 1
            ? ((C = I[0] + "origin=" + b + "://"),
              self.location.href.match(/www/gi) &&
                !I[1].match(/www/gi) &&
                (C += "www."),
              (C += I[1]))
            : (C = p);
          var j = "true" === m || m === !0 ? "allowfullscreen" : "";
          e.data(
            "videomarkup",
            '<iframe style="visible:hidden" src="' +
              b +
              "://www.youtube.com/embed/" +
              v +
              "?" +
              C +
              '" ' +
              j +
              ' width="100%" height="100%" style="width:100%;height:100%"></iframe>'
          );
          break;
        case "vimeo":
          "https:" === location.protocol && (b = "https"),
            e.data(
              "videomarkup",
              '<iframe style="visible:hidden" src="' +
                b +
                "://player.vimeo.com/video/" +
                u +
                "?" +
                p +
                '" webkitallowfullscreen mozallowfullscreen allowfullscreen width="100%" height="100%" style="100%;height:100%"></iframe>'
            );
      }
      var _ = i && "on" == e.data("noposteronmobile");
      if (
        void 0 != e.data("videoposter") &&
        e.data("videoposter").length > 2 &&
        !_
      )
        0 == e.find(".tp-videoposter").length &&
          e.append(
            '<div class="tp-videoposter noSwipe" style="cursor:pointer; position:absolute;top:0px;left:0px;width:100%;height:100%;z-index:3;background-image:url(' +
              e.data("videoposter") +
              '); background-size:cover;background-position:center center;"></div>'
          ),
          0 == e.find("iframe").length &&
            e.find(".tp-videoposter").click(function () {
              if ((a.playVideo(e, o), i)) {
                if (1 == e.data("disablevideoonmobile")) return !1;
                punchgs.TweenLite.to(e.find(".tp-videoposter"), 0.3, {
                  autoAlpha: 0,
                  force3D: "auto",
                  ease: punchgs.Power3.easeInOut,
                }),
                  punchgs.TweenLite.to(e.find("iframe"), 0.3, {
                    autoAlpha: 1,
                    display: "block",
                    ease: punchgs.Power3.easeInOut,
                  });
              }
            });
      else {
        if (i && 1 == e.data("disablevideoonmobile")) return !1;
        0 != e.find("iframe").length ||
          ("youtube" != T && "vimeo" != T) ||
          (e.append(e.data("videomarkup")), r(e, o, !1));
      }
      "none" != e.data("dottedoverlay") &&
        void 0 != e.data("dottedoverlay") &&
        1 != e.find(".tp-dottedoverlay").length &&
        e.append(
          '<div class="tp-dottedoverlay ' + e.data("dottedoverlay") + '"></div>'
        ),
        e.addClass("HasListener"),
        1 == e.data("bgvideo") &&
          punchgs.TweenLite.set(e.find("video, iframe"), { autoAlpha: 0 });
    },
  });
  var d = function (e, t, a) {
      e.addEventListener
        ? e.addEventListener(t, a, !1)
        : e.attachEvent(t, a, !1);
    },
    o = function (e, t, a) {
      var i = {};
      return (i.video = e), (i.videotype = t), (i.settings = a), i;
    },
    r = function (e, d, r) {
      var n = e.find("iframe"),
        p = "iframe" + Math.round(1e5 * Math.random() + 1),
        v = e.data("videoloop"),
        u = "loopandnoslidestop" != v;
      if (
        ((v = "loop" == v || "loopandnoslidestop" == v),
        1 == e.data("forcecover"))
      ) {
        e.removeClass("fullscreenvideo").addClass("coverscreenvideo");
        var c = e.data("aspectratio");
        void 0 != c &&
          c.split(":").length > 1 &&
          a.prepareCoveredVideo(c, d, e);
      }
      if (1 == e.data("bgvideo")) {
        var c = e.data("aspectratio");
        void 0 != c &&
          c.split(":").length > 1 &&
          a.prepareCoveredVideo(c, d, e);
      }
      if (
        (n.attr("id", p),
        r && e.data("startvideonow", !0),
        1 !== e.data("videolistenerexist"))
      )
        switch (e.data("videotype")) {
          case "youtube":
            var g = new YT.Player(p, {
              events: {
                onStateChange: function (e) {
                  var i = e.target.getVideoEmbedCode(),
                    r = jQuery("#" + i.split('id="')[1].split('"')[0]),
                    n = r.closest(".tp-simpleresponsive"),
                    p = r.parent(),
                    c = r.parent().data("player");
                  if (e.data == YT.PlayerState.PLAYING)
                    punchgs.TweenLite.to(p.find(".tp-videoposter"), 0.3, {
                      autoAlpha: 0,
                      force3D: "auto",
                      ease: punchgs.Power3.easeInOut,
                    }),
                      punchgs.TweenLite.to(p.find("iframe"), 0.3, {
                        autoAlpha: 1,
                        display: "block",
                        ease: punchgs.Power3.easeInOut,
                      }),
                      "mute" == p.data("volume") ||
                      a.lastToggleState(p.data("videomutetoggledby"))
                        ? c.mute()
                        : (c.unMute(),
                          c.setVolume(parseInt(p.data("volume"), 0) || 75)),
                      (d.videoplaying = !0),
                      s(p, d),
                      u ? d.c.trigger("stoptimer") : (d.videoplaying = !1),
                      d.c.trigger(
                        "revolution.slide.onvideoplay",
                        o(c, "youtube", p.data())
                      ),
                      a.toggleState(p.data("videotoggledby"));
                  else {
                    if (0 == e.data && v) {
                      var g = t(p.data("videostartat"));
                      -1 != g && c.seekTo(g),
                        c.playVideo(),
                        a.toggleState(p.data("videotoggledby"));
                    }
                    (0 == e.data || 2 == e.data) &&
                      "on" == p.data("showcoveronpause") &&
                      p.find(".tp-videoposter").length > 0 &&
                      (punchgs.TweenLite.to(p.find(".tp-videoposter"), 0.3, {
                        autoAlpha: 1,
                        force3D: "auto",
                        ease: punchgs.Power3.easeInOut,
                      }),
                      punchgs.TweenLite.to(p.find("iframe"), 0.3, {
                        autoAlpha: 0,
                        ease: punchgs.Power3.easeInOut,
                      })),
                      -1 != e.data &&
                        3 != e.data &&
                        ((d.videoplaying = !1),
                        l(p, d),
                        n.trigger("starttimer"),
                        d.c.trigger(
                          "revolution.slide.onvideostop",
                          o(c, "youtube", p.data())
                        ),
                        (void 0 == d.currentLayerVideoIsPlaying ||
                          d.currentLayerVideoIsPlaying.attr("id") ==
                            p.attr("id")) &&
                          a.unToggleState(p.data("videotoggledby"))),
                      0 == e.data && 1 == p.data("nextslideatend")
                        ? (p.data("nextslideatend-triggered", 1),
                          d.c.revnext(),
                          l(p, d))
                        : (l(p, d),
                          (d.videoplaying = !1),
                          n.trigger("starttimer"),
                          d.c.trigger(
                            "revolution.slide.onvideostop",
                            o(c, "youtube", p.data())
                          ),
                          (void 0 == d.currentLayerVideoIsPlaying ||
                            d.currentLayerVideoIsPlaying.attr("id") ==
                              p.attr("id")) &&
                            a.unToggleState(p.data("videotoggledby")));
                  }
                },
                onReady: function (e) {
                  var a = e.target.getVideoEmbedCode(),
                    d = jQuery("#" + a.split('id="')[1].split('"')[0]),
                    o = d.parent(),
                    r = o.data("videorate");
                  o.data("videostart");
                  if (
                    (o.addClass("rs-apiready"),
                    void 0 != r && e.target.setPlaybackRate(parseFloat(r)),
                    o.find(".tp-videoposter").unbind("click"),
                    o.find(".tp-videoposter").click(function () {
                      i || g.playVideo();
                    }),
                    o.data("startvideonow"))
                  ) {
                    o.data("player").playVideo();
                    var n = t(o.data("videostartat"));
                    -1 != n && o.data("player").seekTo(n);
                  }
                  o.data("videolistenerexist", 1);
                },
              },
            });
            e.data("player", g);
            break;
          case "vimeo":
            for (
              var f, y = n.attr("src"), m = {}, h = y, b = /([^&=]+)=([^&]*)/g;
              (f = b.exec(h));

            )
              m[decodeURIComponent(f[1])] = decodeURIComponent(f[2]);
            y =
              void 0 != m.player_id
                ? y.replace(m.player_id, p)
                : y + "&player_id=" + p;
            try {
              y = y.replace("api=0", "api=1");
            } catch (w) {}
            (y += "&api=1"), n.attr("src", y);
            var g = e.find("iframe")[0],
              T = (jQuery("#" + p), $f(p));
            T.addEvent("ready", function () {
              if (
                (e.addClass("rs-apiready"),
                T.addEvent("play", function (t) {
                  e.data("nextslidecalled", 0),
                    punchgs.TweenLite.to(e.find(".tp-videoposter"), 0.3, {
                      autoAlpha: 0,
                      force3D: "auto",
                      ease: punchgs.Power3.easeInOut,
                    }),
                    punchgs.TweenLite.to(e.find("iframe"), 0.3, {
                      autoAlpha: 1,
                      display: "block",
                      ease: punchgs.Power3.easeInOut,
                    }),
                    d.c.trigger(
                      "revolution.slide.onvideoplay",
                      o(T, "vimeo", e.data())
                    ),
                    (d.videoplaying = !0),
                    s(e, d),
                    u ? d.c.trigger("stoptimer") : (d.videoplaying = !1),
                    "mute" == e.data("volume") ||
                    a.lastToggleState(e.data("videomutetoggledby"))
                      ? T.api("setVolume", "0")
                      : T.api(
                          "setVolume",
                          parseInt(e.data("volume"), 0) / 100 || 0.75
                        ),
                    a.toggleState(e.data("videotoggledby"));
                }),
                T.addEvent("playProgress", function (a) {
                  var i = t(e.data("videoendat"));
                  if (
                    (e.data("currenttime", a.seconds),
                    0 != i &&
                      Math.abs(i - a.seconds) < 0.3 &&
                      i > a.seconds &&
                      1 != e.data("nextslidecalled"))
                  )
                    if (v) {
                      T.api("play");
                      var o = t(e.data("videostartat"));
                      -1 != o && T.api("seekTo", o);
                    } else
                      1 == e.data("nextslideatend") &&
                        (e.data("nextslideatend-triggered", 1),
                        e.data("nextslidecalled", 1),
                        d.c.revnext()),
                        T.api("pause");
                }),
                T.addEvent("finish", function (t) {
                  l(e, d),
                    (d.videoplaying = !1),
                    d.c.trigger("starttimer"),
                    d.c.trigger(
                      "revolution.slide.onvideostop",
                      o(T, "vimeo", e.data())
                    ),
                    1 == e.data("nextslideatend") &&
                      (e.data("nextslideatend-triggered", 1), d.c.revnext()),
                    (void 0 == d.currentLayerVideoIsPlaying ||
                      d.currentLayerVideoIsPlaying.attr("id") ==
                        e.attr("id")) &&
                      a.unToggleState(e.data("videotoggledby"));
                }),
                T.addEvent("pause", function (t) {
                  e.find(".tp-videoposter").length > 0 &&
                    "on" == e.data("showcoveronpause") &&
                    (punchgs.TweenLite.to(e.find(".tp-videoposter"), 0.3, {
                      autoAlpha: 1,
                      force3D: "auto",
                      ease: punchgs.Power3.easeInOut,
                    }),
                    punchgs.TweenLite.to(e.find("iframe"), 0.3, {
                      autoAlpha: 0,
                      ease: punchgs.Power3.easeInOut,
                    })),
                    (d.videoplaying = !1),
                    l(e, d),
                    d.c.trigger("starttimer"),
                    d.c.trigger(
                      "revolution.slide.onvideostop",
                      o(T, "vimeo", e.data())
                    ),
                    (void 0 == d.currentLayerVideoIsPlaying ||
                      d.currentLayerVideoIsPlaying.attr("id") ==
                        e.attr("id")) &&
                      a.unToggleState(e.data("videotoggledby"));
                }),
                e.find(".tp-videoposter").unbind("click"),
                e.find(".tp-videoposter").click(function () {
                  return i ? void 0 : (T.api("play"), !1);
                }),
                e.data("startvideonow"))
              ) {
                T.api("play");
                var r = t(e.data("videostartat"));
                -1 != r && T.api("seekTo", r);
              }
              e.data("videolistenerexist", 1);
            });
        }
      else {
        var k = t(e.data("videostartat"));
        switch (e.data("videotype")) {
          case "youtube":
            r &&
              (e.data("player").playVideo(),
              -1 != k && e.data("player").seekTo());
            break;
          case "vimeo":
            if (r) {
              var T = $f(e.find("iframe").attr("id"));
              T.api("play"), -1 != k && T.api("seekTo", k);
            }
        }
      }
    },
    n = function (e, r, n) {
      if (i && 1 == e.data("disablevideoonmobile")) return !1;
      var p = e.find("video"),
        v = p[0],
        u = p.parent(),
        c = e.data("videoloop"),
        g = "loopandnoslidestop" != c;
      if (
        ((c = "loop" == c || "loopandnoslidestop" == c),
        u.data("metaloaded", 1),
        void 0 == p.attr("control") &&
          (0 != e.find(".tp-video-play-button").length ||
            i ||
            e.append(
              '<div class="tp-video-play-button"><i class="revicon-right-dir"></i><span class="tp-revstop">&nbsp;</span></div>'
            ),
          e.find("video, .tp-poster, .tp-video-play-button").click(function () {
            e.hasClass("videoisplaying") ? v.pause() : v.play();
          })),
        1 == e.data("forcecover") ||
          e.hasClass("fullscreenvideo") ||
          1 == e.data("bgvideo"))
      )
        if (1 == e.data("forcecover") || 1 == e.data("bgvideo")) {
          u.addClass("fullcoveredvideo");
          var f = e.data("aspectratio") || "4:3";
          a.prepareCoveredVideo(f, r, e);
        } else u.addClass("fullscreenvideo");
      var y = e.find(".tp-vid-play-pause")[0],
        m = e.find(".tp-vid-mute")[0],
        h = e.find(".tp-vid-full-screen")[0],
        b = e.find(".tp-seek-bar")[0],
        w = e.find(".tp-volume-bar")[0];
      void 0 != y &&
        d(y, "click", function () {
          1 == v.paused ? v.play() : v.pause();
        }),
        void 0 != m &&
          d(m, "click", function () {
            0 == v.muted
              ? ((v.muted = !0), (m.innerHTML = "Mit Ton"))
              : ((v.muted = !1), (m.innerHTML = "Ohne Ton"));
          }),
        void 0 != h &&
          h &&
          d(h, "click", function () {
            v.requestFullscreen
              ? v.requestFullscreen()
              : v.mozRequestFullScreen
              ? v.mozRequestFullScreen()
              : v.webkitRequestFullscreen && v.webkitRequestFullscreen();
          }),
        void 0 != b &&
          (d(b, "change", function () {
            var e = v.duration * (b.value / 100);
            v.currentTime = e;
          }),
          d(b, "mousedown", function () {
            e.addClass("seekbardragged"), v.pause();
          }),
          d(b, "mouseup", function () {
            e.removeClass("seekbardragged"), v.play();
          })),
        d(v, "timeupdate", function () {
          var a = (100 / v.duration) * v.currentTime,
            i = t(e.data("videoendat")),
            d = v.currentTime;
          if (
            (void 0 != b && (b.value = a),
            0 != i &&
              -1 != i &&
              Math.abs(i - d) <= 0.3 &&
              i > d &&
              1 != e.data("nextslidecalled"))
          )
            if (c) {
              v.play();
              var o = t(e.data("videostartat"));
              -1 != o && (v.currentTime = o);
            } else
              1 == e.data("nextslideatend") &&
                (e.data("nextslideatend-triggered", 1),
                e.data("nextslidecalled", 1),
                (r.just_called_nextslide_at_htmltimer = !0),
                r.c.revnext(),
                setTimeout(function () {
                  r.just_called_nextslide_at_htmltimer = !1;
                }, 1e3)),
                v.pause();
        }),
        void 0 != w &&
          d(w, "change", function () {
            v.volume = w.value;
          }),
        d(v, "play", function () {
          e.data("nextslidecalled", 0),
            "mute" == e.data("volume") && (v.muted = !0),
            e.addClass("videoisplaying"),
            s(e, r),
            g
              ? ((r.videoplaying = !0),
                r.c.trigger("stoptimer"),
                r.c.trigger(
                  "revolution.slide.onvideoplay",
                  o(v, "html5", e.data())
                ))
              : ((r.videoplaying = !1),
                r.c.trigger("starttimer"),
                r.c.trigger(
                  "revolution.slide.onvideostop",
                  o(v, "html5", e.data())
                )),
            punchgs.TweenLite.to(e.find(".tp-videoposter"), 0.3, {
              autoAlpha: 0,
              force3D: "auto",
              ease: punchgs.Power3.easeInOut,
            }),
            punchgs.TweenLite.to(e.find("video"), 0.3, {
              autoAlpha: 1,
              display: "block",
              ease: punchgs.Power3.easeInOut,
            });
          var t = e.find(".tp-vid-play-pause")[0],
            i = e.find(".tp-vid-mute")[0];
          void 0 != t && (t.innerHTML = "Pause"),
            void 0 != i && v.muted && (i.innerHTML = "Mit Ton"),
            a.toggleState(e.data("videotoggledby"));
        }),
        d(v, "pause", function () {
          e.find(".tp-videoposter").length > 0 &&
            "on" == e.data("showcoveronpause") &&
            !e.hasClass("seekbardragged") &&
            (punchgs.TweenLite.to(e.find(".tp-videoposter"), 0.3, {
              autoAlpha: 1,
              force3D: "auto",
              ease: punchgs.Power3.easeInOut,
            }),
            punchgs.TweenLite.to(e.find("video"), 0.3, {
              autoAlpha: 0,
              ease: punchgs.Power3.easeInOut,
            })),
            e.removeClass("videoisplaying"),
            (r.videoplaying = !1),
            l(e, r),
            r.c.trigger("starttimer"),
            r.c.trigger(
              "revolution.slide.onvideostop",
              o(v, "html5", e.data())
            );
          var t = e.find(".tp-vid-play-pause")[0];
          void 0 != t && (t.innerHTML = "Play"),
            (void 0 == r.currentLayerVideoIsPlaying ||
              r.currentLayerVideoIsPlaying.attr("id") == e.attr("id")) &&
              a.unToggleState(e.data("videotoggledby"));
        }),
        d(v, "ended", function () {
          l(e, r),
            (r.videoplaying = !1),
            l(e, r),
            r.c.trigger("starttimer"),
            r.c.trigger(
              "revolution.slide.onvideostop",
              o(v, "html5", e.data())
            ),
            1 == e.data("nextslideatend") &&
              (1 == !r.just_called_nextslide_at_htmltimer &&
                (e.data("nextslideatend-triggered", 1),
                r.c.revnext(),
                (r.just_called_nextslide_at_htmltimer = !0)),
              setTimeout(function () {
                r.just_called_nextslide_at_htmltimer = !1;
              }, 1500)),
            e.removeClass("videoisplaying");
        });
    },
    s = function (e, t) {
      void 0 == t.playingvideos && (t.playingvideos = new Array()),
        e.data("stopallvideos") &&
          void 0 != t.playingvideos &&
          t.playingvideos.length > 0 &&
          ((t.lastplayedvideos = jQuery.extend(!0, [], t.playingvideos)),
          jQuery.each(t.playingvideos, function (e, i) {
            a.stopVideo(i, t);
          })),
        t.playingvideos.push(e),
        (t.currentLayerVideoIsPlaying = e);
    },
    l = function (e, t) {
      void 0 != t.playingvideos &&
        t.playingvideos.splice(jQuery.inArray(e, t.playingvideos), 1);
    };
})(jQuery);
