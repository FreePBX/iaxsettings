��    6      �  I   |      �  �   �  !   <  	   ^     h     z  k   �  R  �  �   O  �    �   �
  �  �    h  �  �  B  R  �   �     -  	   :     D  .   Q  	   �  >   �  /   �     �               *     ?     S     d     q     �     �     �     �     �     �     �  D   �     )  R   0     �  v  �     �        6   .     e     j     n     u     �  ?   �     �     �  �    �   �  %   �     �     �     �  �   �  �  �    l  �  n  �   �   8  �!  J  .$  �  y%  �  *(  �   �)     �*     �*     �*  E   �*     +  d   &+  A   �+     �+     �+     �+  )   ,     7,     R,     d,     t,     �,     �,     �,     �,     �,     �,     -  q   -  	   �-  `   �-     �-  G  �-     D0  &   U0  Y   |0     �0     �0     �0     �0  &   1  ]   31     �1     �1                   3                       .      '          ,   &                (      )              5              6       2          #                                   	       $              +   "   /         *       1   %   !   -   
   0              4        If you clear each codec and then add them one at a time, submitting with each addition, they will be added in order which will effect the codec priority. %s must be a non-negative integer Add Field Advanced Settings Asterisk IAX Settings Asterisk: bandwidth. Specify bandwidth of low, medium, or high to control which codecs are used in general. Asterisk: bindaddr. The IP address to bind to and listen for calls on the Bind Port. If set to 0.0.0.0 Asterisk will listen on all addresses. To bind to multiple IP addresses or ports, use the Other 'IAX Settings' fields where you can put settings such as:<br /> bindaddr=192.168.10.100:4555.<br />  It is recommended to leave this blank. Asterisk: bindport. Local incoming UDP Port that Asterisk will bind to and listen for IAX messages. The IAX standard is 4569 and in most cases this is what you want. It is recommended to leave this blank. Asterisk: codecpriority. Controls the codec negotiation of an inbound IAX call. This option is inherited to all user entities.  It can also be defined in each user entity separately which will override the setting here. The valid values are:<br />host - Consider the host's preferred order ahead of the caller's.<br />caller - Consider the callers preferred order ahead of the host's.<br /> disabled - Disable the consideration of codec preference altogether. (this is the original behavior before preferences were added)<br />reqonly  - Same as disabled, only do not consider capabilities if the requested format is not available the call will only be accepted if the requested format is available. Asterisk: delayreject. For increased security against brute force password attacks enable this which will delay the sending of authentication reject for REGREQ or AUTHREP if there is a password. Asterisk: forcejitterbuffer. Forces the use of a jitterbuffer on the receive side of an IAX channel. Normally the jitter buffer will not be used if receiving a jittery channel but sending it off to another channel such as a SIP channel to an endpoint, since there is typically a jitter buffer at the far end. This will force the use of the jitter buffer before sending the stream on. This is not typically desired as it adds additional latency into the stream. Asterisk: jitterbuffer. You can adjust several parameters relating to the jitter buffer. The jitter buffer's function is to compensate for varying network delay. The jitter buffer works for INCOMING audio - the outbound audio will be dejittered by the jitter buffer at the other end. Asterisk: maxjitterbuffer. Max length of the jitterbuffer in milliseconds.<br /> Asterisk: resyncthreshold. When the jitterbuffer notices a significant change in delay that continues over a few frames, it will resync, assuming that the change in delay was caused by a timestamping mix-up. The threshold for noticing a change in delay is measured as twice the measured jitter plus this resync threshold. Resyncing can be disabled by setting this parameter to -1. Asterisk: maxjitterinterps. The maximum number of interpolation frames the jitterbuffer should return in a row. Since some clients do not send CNG/DTX frames to indicate silence, the jitterbuffer will assume silence has begun after returning this many interpolations. This prevents interpolating throughout a long silence. Asterisk: minregexpire, maxregexpire. Minimum and maximum length of time that IAX peers can request as a registration expiration interval (in seconds). Audio Codecs Bandwidth Bind Address Bind Address (bindaddr) must be an IP address. Bind Port Bind Port (bindport) must be between 1024..65535, default 4569 Check to enable and then choose allowed codecs. Codec Priority Codec Settings Delay Auth Rejects Enable Video Support Force Jitter Buffer General Settings IAX Settings Jitter Buffer Enable Jitter Buffer Size Max Interpolations No Other IAX Settings Registration Times Reset Settings Settings in %s may override these. Those settings should be removed. Submit Use to configure Various Asterisk IAX Settings in the General section of iax.conf. Yes You may set any other IAX settings not present here that are allowed to be configured in the General section of iax.conf. There will be no error checking against these settings so check them carefully. They should be entered as:<br /> [setting] = [value]<br /> in the boxes below. Click the Add Field box to add additional fields. Blank boxes will be deleted when submitted. already exists checking for iaxsettings table.. fatal error occurred populating defaults, check module high low medium none, creating table populating default codecs.. resyncthreshold must be a non-negative integer or -1 to disable ulaw, alaw, gsm added unset Project-Id-Version: PACKAGE VERSION
Report-Msgid-Bugs-To: 
POT-Creation-Date: 2017-03-07 13:47-0800
PO-Revision-Date: 2017-07-08 10:02+0200
Last-Translator: PETER <ftek@ymail.com>
Language-Team: Vietnamese <http://weblate.freepbx.org/projects/freepbx/iaxsettings/vi/>
Language: vi
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=1; plural=0;
X-Generator: Weblate 2.4
  Nếu bạn xóa từng codec và sau đó thêm lần lượt một lần 1 codec, gửi kèm với mỗi bổ sung, chúng sẽ được thêm vào lần lượt và điều này sẽ khiến codec ưu tiên có hiệu lực. %s phải là số nguyên không âm Thêm trường Cài đặt nâng cao Cài đặt IAX Asterisk Asterisk: băng thông. Xác định băng thông thấp, trung bình, hoặc cao để kiểm soát các codec được sử dụng thông thường. Asterisk: bindaddr. Địa chỉ IP để liên kết và nghe các cuộc gọi trên Cổng giao tiếp liên kết . Nếu cài đặt là 0.0.0.0 Asterisk sẽ nghe trên tất cả các địa chỉ. Để liên kết với nhiều địa chỉ IP hoặc cổng giao tiếp, sử dụng các trường ' Cài đặt IAX ' khác, nơi bạn có thể để các cài đặt như: <br /> bindaddr = 192.168.10.100: 4555. <br /> Bạn nên để trống trường này. Asterisk: bindport. Cổng UDP đến tại chỗ mà Asterisk sẽ liên kết tới và nghe tin nhắn của IAX. Tiêu chuẩn IAX là 4569 và trong hầu hết các trường hợp đây là những gì bạn muốn. Nên để trống trường này. Asterisk: codecpriority. Kiểm soát codec phụ của cuộc gọi IAX gửi đến. Tùy chọn này được kế thừa cho tất cả các đối tượng người dùng. Nó cũng có thể được xác định trong mỗi đối tượng người dùng riêng biệt mà sẽ ghi đè cài đặt ở đây. Các giá trị hợp lệ là: :<br />host - Xem xét thứ tự ưu tiên của host trước người gọi. <br />Caller - Xem xét thứ tự ưu tiên người gọi trước host. <br /> disabled - Vô hiệu hoá việc xem xét các codec tùy thích hoàn toàn . (Đây là hành vi ban đầu trước khi các tùy thích được thêm vào) <br /> reqonly - Tương tự như bị vô hiệu hoá, không xem xét các khả năng nếu định dạng được yêu cầu không có sẵn; Cuộc gọi sẽ chỉ được chấp nhận nếu định dạng yêu cầu có sẵn. Asterisk: delayreject. Để tăng tính an toàn chống lại các cuộc tấn công mật khẩu brute force, điều này sẽ làm chậm việc gửi từ chối xác thực đối với  REGREQ hoặc AUTHREP nếu có một mật khẩu. Asterisk: forcejitterbuffer. Bắt buộc phải sử dụng  jitterbuffer ở phía nhận của kênh IAX. Thông thường,  jitterbuffer  sẽ không được sử dụng nếu nhận được một kênh  jitter nhưng lại gửi nó đến một kênh khác ví dụ như kênh SIP tới một điểm cuối, vì thường có một jitterbuffer ở phía cuối. Điều này sẽ buộc phải sử dụng jitter buffer trước khi gửi luồng. Vì điều này sẽ thêm độ trễ bổ sung vào luồng nên nó không phải là điều mong muốn. Asterisk: jitterbuffer. Bạn có thể điều chỉnh một số thông số liên quan đến jitter buffer. Chức năng của jitter buffer là để bù cho việc trễ mạng. Các âm thanh đến sẽ hoạt động dựa trên Jitter buffer  - âm thanh đi ra sẽ bị tráo đổi bởi jitter buffer ở đầu kia. Asterisk: maxjitterbuffer. Chiều dài tối đa của  jitterbuffer tính bằng mili giây.<br /> Asterisk: resyncthreshold. Khi jitterbuffer thông báo một sự thay đổi quan trọng đối với việc chậm trễ kéo dài trên một vài khung hình, nó sẽ tái đồng bộ hóa (resync), giả sử rằng sự thay đổi trong sự chậm trễ là do sự pha trộn timestamping. Ngưỡng cho việc thông báo một thay đổi về độ trễ được đo sẽ bằng hai lần jitter đã đo cộng thêm với ngưỡng tái đồng bộ hóa ( resync). Có thể vô hiệu việc tái đồng bộ hóa (resync) bằng cách đặt tham số này là -1. Asterisk: maxjitterinterps. Số frame nội suy tối đa, jitterbuffer sẽ trở lại trong một hàng. Vì một số máy khách không gửi các frame  CNG / DTX để biểu thị sự im lặng, jitterbuffer sẽ cho rằng im lặng bắt đầu sau khi nhiều nội suy được trả lại. Điều này sẽ tránh việc nội suy trong suốt quá trình  im lặng dài. Asterisk: minregexpire, maxregexpire. Khoảng thời gian tối thiểu và tối đa mà các đồng đẳng IAX có thể yêu cầu như một đăng ký khoảng thời gian hết hạn (tính bằng giây). Các codec âm thanh Băng thông Địa chỉ liên kết Địa chỉ liên kết (bindaddr) phải là một địa chỉ IP. Cổng giao tiếp liên kết Cổng giao tiếp liên kết ( bindport) phải trong khoảng 1024..65535, mặc định là 4569 Kiểm tra để baath và chọn các codecs được cho phép. Codec ưu tiên Cài đặt Codec Hoãn Từ chối xác thực Kích hoạt tính năng hỗ trợ Video Bắt buộc Jitter Buffer Cài đặt chung Cài đặt IAX Kích hoạt Jitter Buffer Kich thước Jitter Buffer Các nội suy tối đa Không Các cài đặt IAX khác Thời gian đăng ký Cài đặt lại Cài đặt Các cài đặt trong %s có thể ghi đè lên các cài đặt này. Các cài đặt kia nên được xóa. Gửi đi Sử dụng để cấu hình các cài đặt IAX Asterisk trong phần General của iax.conf. Có Bạn có thể cài đặt bất kỳ các cài đặt IAX nào khác mà hiện nó không có ở đây. Chúng được phép cấu hình trong phần General của iax.conf. Việc kiểm tra lỗi sẽ không được thực hiện trên các cài đặt này cho nên bạn cần phải kiểm tra chúng cẩn thận. Chúng phải được nhập dưới dạng: <br /> [setting] = [value] <br /> trong các hộp thoại dưới đây. Nhấp vào hộp thoại  Add Field (Thêm trường) để thêm các trường bổ sung. Các hộp thoại khi gửi sẽ bị xóa. Đã tồn tại Đang kiểm tra bảng  iaxsettings.. Lỗi cực nghiêm trọng xảy ra liên quan đến mặc định, kiểm tra mô đun cao thấp trung bình không có, đang tạo bảng Đang nạp các codec mặc định.. resyncthreshold phải là số nguyên không âm hoặc cài đặt là -1 để vô hiệu Đã thêm ulaw, alaw, gsm Không cài đặt 