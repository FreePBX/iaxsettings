Þ    '      T  5         `     a  !   ü  	        (  k   >  R  ª  Ì   ý  »  Ê  Â   	  Ì  I
      Í  2  B        C     Û  	   è     ò  .   ÿ  	   .  >   8  /   w     §     ¶     É     Ý     ð                    ,  D   5     z  v  ~     õ     ú     þ  ?        E  ³  K  ¸   ÿ  6   ¸     ï             N  ½  í     H  ú  Ì   C  L    u  ]   4  Ó!  ¸  $     Á%     G&  	   ]&     g&  V   &     Ù&  k   ï&  {   ['     ×'  !   ö'  *   (  '   C(     k(  	   ~(     (     (     ¨(  r   ¯(     ")  ß  ))     	+     +     +  s   +  	   +                           "   '         !   
                           &                              %                 #              	                                           $     If you clear each codec and then add them one at a time, submitting with each addition, they will be added in order which will effect the codec priority. %s must be a non-negative integer Add Field Asterisk IAX Settings Asterisk: bandwidth. Specify bandwidth of low, medium, or high to control which codecs are used in general. Asterisk: bindaddr. The IP address to bind to and listen for calls on the Bind Port. If set to 0.0.0.0 Asterisk will listen on all addresses. To bind to multiple IP addresses or ports, use the Other 'IAX Settings' fields where you can put settings such as:<br /> bindaddr=192.168.10.100:4555.<br />  It is recommended to leave this blank. Asterisk: bindport. Local incoming UDP Port that Asterisk will bind to and listen for IAX messages. The IAX standard is 4569 and in most cases this is what you want. It is recommended to leave this blank. Asterisk: codecpriority. Controls the codec negotiation of an inbound IAX call. This option is inherited to all user entities.  It can also be defined in each user entity separately which will override the setting here. The valid values are:<br />host - Consider the host's preferred order ahead of the caller's.<br />caller - Consider the callers preferred order ahead of the host's.<br /> disabled - Disable the consideration of codec preference altogether. (this is the original behavior before preferences were added)<br />reqonly  - Same as disabled, only do not consider capabilities if the requested format is not available the call will only be accepted if the requested format is available. Asterisk: delayreject. For increased security against brute force password attacks enable this which will delay the sending of authentication reject for REGREQ or AUTHREP if there is a password. Asterisk: forcejitterbuffer. Forces the use of a jitterbuffer on the receive side of an IAX channel. Normally the jitter buffer will not be used if receiving a jittery channel but sending it off to another channel such as a SIP channel to an endpoint, since there is typically a jitter buffer at the far end. This will force the use of the jitter buffer before sending the stream on. This is not typically desired as it adds additional latency into the stream. Asterisk: jitterbuffer. You can adjust several parameters relating to the jitter buffer. The jitter buffer's function is to compensate for varying network delay. The jitter buffer works for INCOMING audio - the outbound audio will be dejittered by the jitter buffer at the other end. Asterisk: maxjitterbuffer. Max length of the jitterbuffer in milliseconds.<br /> Asterisk: resyncthreshold. When the jitterbuffer notices a significant change in delay that continues over a few frames, it will resync, assuming that the change in delay was caused by a timestamping mix-up. The threshold for noticing a change in delay is measured as twice the measured jitter plus this resync threshold. Resyncing can be disabled by setting this parameter to -1. Asterisk: maxjitterinterps. The maximum number of interpolation frames the jitterbuffer should return in a row. Since some clients do not send CNG/DTX frames to indicate silence, the jitterbuffer will assume silence has begun after returning this many interpolations. This prevents interpolating throughout a long silence. Asterisk: minregexpire, maxregexpire. Minimum and maximum length of time that IAX peers can request as a registration expiration interval (in seconds). Audio Codecs Bandwidth Bind Address Bind Address (bindaddr) must be an IP address. Bind Port Bind Port (bindport) must be between 1024..65535, default 4569 Check to enable and then choose allowed codecs. Codec Priority Delay Auth Rejects Force Jitter Buffer Jitter Buffer Size Max Interpolations No Other IAX Settings Registration Times Settings Settings in %s may override these. Those settings should be removed. Yes You may set any other IAX settings not present here that are allowed to be configured in the General section of iax.conf. There will be no error checking against these settings so check them carefully. They should be entered as:<br /> [setting] = [value]<br /> in the boxes below. Click the Add Field box to add additional fields. Blank boxes will be deleted when submitted. high low medium resyncthreshold must be a non-negative integer or -1 to disable unset Project-Id-Version: FreePBX 2.10.0.3
Report-Msgid-Bugs-To: 
POT-Creation-Date: 2018-09-07 13:07-0400
PO-Revision-Date: 2014-06-03 09:48+0200
Last-Translator: Kevin <kevin@qloog.com>
Language-Team: Japanese <http://git.freepbx.org/projects/freepbx/iaxsettings/ja/>
Language: ja_JP
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=1; plural=0;
X-Generator: Weblate 1.9-dev
  ãã¹ã¦ã®ã³ã¼ããã¯ãã¯ãªã¢ãããã®å¾ä¸ã¤ãã¤è¿½å ããæ¯ã«å¤æ´ãé©ç¨ããã¨ãè¿½å ããé çªã§ã³ã¼ããã¯åªåé ä½ãè¨­å®ããã¾ãã %s ã¯éè² ã®æ´æ°ã§ãªããã°ãªãã¾ããã ãã£ã¼ã«ããè¿½å  Asterisk IAX è¨­å® å¯¾å¿ããAsteriskè¨­å®: bandwidthãä½¿ç¨ããã³ã¼ããã¯ãã³ã³ãã­ã¼ã«ããããã«ãä½ãä¸­ã¾ãã¯é«ã®å¸¯åå¹ãæå®ãã¾ãã å¯¾å¿ããAsteriskè¨­å®: bindaddrããã® IP ã¢ãã¬ã¹ã®ããã¤ã³ããã¼ãã§æå®ãããã¼ãçªå·ã listen (åä¿¡å¾ã¡)ãã¾ãã0.0.0.0 ãè¨­å®ããå ´åã«ã¯ããã®ãã¹ãã«å²ãå½ã¦ããã¦ãããã¹ã¦ã® IP ã¢ãã¬ã¹ã§ listen ãã¾ããç©ºã«è¨­å®ãããã¨ãæ¨å¥¨ãã¾ãã å¯¾å¿ããAsteriskè¨­å®: bindportãAsteriskã IPã¡ãã»ã¼ã¸ãåä¿¡ããã­ã¼ã«ã«çä¿¡ãã¼ããSIPã®æ¨æºãã¼ãã¯5060ã§ãéå¸¸å¤æ´ããå¿è¦ã¯ããã¾ãããç©ºã«è¨­å®ãããã¨ãæ¨å¥¨ãã¾ãã å¯¾å¿ãã Asterisk è¨­å®: codecpriorityãçä¿¡ IAX ã³ã¼ã«ã®ã³ã¼ããã¯ãã´ã·ã¨ã¼ã·ã§ã³ãã³ã³ãã­ã¼ã«ãã¾ãããã®ãªãã·ã§ã³ã¯ããã¹ã¦ã®ã¦ã¼ã¶ã«é©ç¨ããã¾ãããã¦ã¼ã¶å¥ã«å®ç¾©ããã¦ããå ´åã«ã¯ãåå¥ã®è¨­å®ã¯ããã§è¨­å®ãããå¤ããªã¼ãã¼ã©ã¤ããã¾ããä½¿ç¨å¯è½ãªå¤ã¯: <br/> host - ãã¹ãã®åªåé ä½ãåªåãã <br/> caller - çºä¿¡èã®åªåé ä½ãåªåãã<br/> disabled - ã³ã¼ããã¯åªåé ä½ãç¡è¦ãã (ãã®è¨­å®ãè¿½å ããåã®æå), <br/> reqonly - disabled ã¨åæ§ã ãããªã¯ã¨ã¹ãããããã©ã¼ãããã«å¯¾å¿ãã¦ããªãå ´åã«ã¯ãã³ã¼ã«ãåçããªãããªã¯ã¨ã¹ãããããã©ã¼ãããã«å¯¾å¿ãã¦ããå ´åã«ã®ã¿ã³ã¼ã«ãåçããã å¯¾å¿ããAsteriskè¨­å®: delayrejectãç·å½ãæ»æã®å¯¾ç­ã¨ãã¦æå¹ã§ãããã¹ã¯ã¼ããè¨­å®ããã¦ããå ´åã«ãREGREQ or AUTHREP ã®èªè¨¼å¦å®å¿ç­ãéå»¶ããã¾ãã å¯¾å¿ããAsteriskè¨­å®: forcejitterbufferãIAX ãã£ãã«ã®åä¿¡å´ã«ã¸ãã¿ã¼ãããã¡ã¼ãå¼·å¶ãã¾ããéå¸¸ãã¸ãã¿ã¼ã®ãããã£ãã«ããåä¿¡ããå¥ SIP ãã£ãã«ã«éä¿¡ããå ´åãç¸æå´ã«ãã¸ãã¿ã¼ãããã¡ã¼ããããããã­ã¼ã«ã«ã®ã¸ãã¿ã¼ãããã¡ã¼ã¯ä½¿ç¨ããã¾ããããã®è¨­å®ãæå¹ã«ããã¨ãã¹ããªã¼ã ãéä¿¡ããåã«ã¸ãã¿ã¼ãããã¡ã¼ãå¼·å¶çã«ä½¿ç¨ãã¾ããã¹ããªã¼ã ã«ã¬ã¤ãã³ã·ã¼ãå ãããããéå¸¸ã¯æã¾ããããã¾ããã å¯¾å¿ããAsteriskè¨­å®: jitterbufferãã¸ãã¿ã¼ãããã¡ã¼ã®ãã©ã¡ã¼ã¿ãèª¿æ´ã§ãã¾ããã¸ãã¿ã¼ãããã¡ã¼ã«ããå¤åãããããã¯ã¼ã¯éå»¶ãè£æ­£ã§ãã¾ããã¸ãã¿ã¼ãããã¡ã¼ã¯çä¿¡é³å£°ã«ç¨ããããçºä¿¡é³å£°ã¯ç¸æå´ã®ã¸ãã¿ã¼ãããã¡ã¼ã«ãããã¸ãã¿ã¼ãåãé¤ããã¾ãã å¯¾å¿ããAsteriskè¨­å®: maxjitterbufferãã¸ãã¿ã¼ãããã¡ã¼ã®æå¤§é· (ããªç§) <br/>å¯¾å¿ããAsteriskè¨­å®: resyncthresholdãã¸ãã¿ã¼ãããã¡ã¼ã¯ãæ°ãã¬ã¼ã ã«æ¸¡ãå¤§ããªéå»¶å¤åãæ¤åºããã¨ãéå»¶å¤åãã¿ã¤ã ã¹ã¿ã³ãã®é¯ç¶ã«ãããã®ã¨ä»®å®ããååæãã¾ããååæã®è¦å¦ã®æ¤åºã¯ãæ¸¬å®ãããã¸ãã¿ã¼éã® 2 åã¨resyncthresholdã®å¤ãæ¯è¼ãããã¨ã«ãã£ã¦è¡ããã¾ãããã®å¤ã -1 ã«è¨­å®ããã¨ãååæã¯ç¡å¹ã«ãªãã¾ãã å¯¾å¿ããAsteriskè¨­å®: maxjitterinterpsãã¸ãã¿ã¼ãããã¡ã¼ãä¸åº¦ã«è¿ãæå¤§ã®è£éãã¬ã¼ã ã®æ°ãç¡é³ãè¡¨ã CNG/DTX ãã¬ã¼ã ãéä¿¡ããªãã¯ã©ã¤ã¢ã³ããå­å¨ãããããã¸ãã¿ã¼ãããã¡ã¼ã¯æå®ãããè£éãã¬ã¼ã ãéåºå¾ãä¿¡å·ã¯ç¡é³ã¨ã¿ãªãã¾ãããã®è¨­å®ãä½¿ç¨ããã¨ãç¡é³ç¶æãé·ãè£éãç¶ãããã¨ãåé¿ã§ãã¾ãã å¯¾å¿ããAsteriskè¨­å®: minregexpire, maxregexpireãIAX ãã¢ããªã¯ã¨ã¹ãã§ããç»é²ã®æå°ã»æå¤§æé (ç§)ã é³å£°ã³ã¼ããã¯ å¸¯åå¹ ãã¤ã³ãIPã¢ãã¬ã¹ ãã¤ã³ãã¢ãã¬ã¹ (bindaddr) ã¯IPã¢ãã¬ã¹ã§ãªããã°ãªãã¾ããã ãã¤ã³ããã¼ã ãã¤ã³ããã¼ã (bindport)ã1024 ï½ 65535 ã§ãªããã°ãªãã¾ãããããã©ã«ã: 5060ã ãããªãµãã¼ããä½¿ç¨ããã«ã¯ãæå¹ãé¸æããä½¿ç¨ããã³ã¼ããã¯ãé¸æãã¦ãã ããã ã³ã¼ããã¯ã®åªåé ä½ èªè¨¼å¦å®å¿ç­ãéå»¶ãã ã¸ãã¿ã¼ãããã¡ã¼ã®å¼·å¶ä½¿ç¨ ã¸ãã¿ã¼ãããã¡ã¼ã®ãµã¤ãº æå¤§è£éåæ° ããã ãã®ä»IAXè¨­å® ç»é²åæ° è¨­å® %s ã®è¨­å®ã¯ãããè¨­å®ããªã¼ãã¼ã©ã¤ãããå¯è½æ§ããããããåé¤ãæ¨å¥¨ãã¾ãã ã¯ã iax.confã®'general'ã»ã¯ã·ã§ã³ã§è¨­å®ã§ããããã®ä»ã®SIPè¨­å®ãããã§è¨è¿°ã§ãã¾ããè¨­å®ã®ã¨ã©ã¼ãã§ãã¯ã¯è¡ãã¾ããã®ã§ãå¥åå¤ãããç¢ºèªãã¦ãã ãããä»¥ä¸ã®ãã­ã¹ãããã¯ã¹ã«æ¬¡ã®ããã«å¥åãã¾ã: <br/> [è¨­å®] = [å¤] <br/>ãã£ã¼ã«ããè¿½å ããã«ã¯ãããã£ã¼ã«ãè¿½å ããã¿ã³ãã¯ãªãã¯ãã¦ãã ãããç©ºã®ããã¯ã¹ã¯è¨­å®é©ç¨æã«åé¤ããã¾ãã é« ä½ ä¸­ resyncthreshold ã¯éè² ã®æ´æ°ã§ãªããã°ãªãã¾ãããç¡å¹ã«ããã«ã¯ã-1 ã«è¨­å®ãã¾ãã æªè¨­å® 