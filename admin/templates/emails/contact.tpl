<div class="mesajKap" style="width: 600px; background: #525252; color: #FFF; font-family: Arial; font-size: 13px; border-radius: 5px; overflow: hidden;">
    <div class="mesaj_headlines" style="font-weight: 600; width: 100%; height: 40px; line-height: 40px; background: #0552a2; box-sizing: border-box; padding: 0 15px;"> {{form_name}}</div>
    <div class="mesaj_content" style="box-sizing: border-box; width: 100%; background: #f3f3f3; color: #2f2f2f; padding: 40px 20px;">
        <table border="1" cellpadding="0" cellspacing="0" style="border-color:#fff;width: 90%;">
            <tr>
                <td width="150" style="padding: 10px;">Kullanıcı</td>
                <td style="padding: 10px;">
                    {{message["user_name"]}}
                </td>
            </tr>
            <tr>
                <td width="150" style="padding: 10px;">Kullanıcı Email</td>
                <td style="padding: 10px;">
                    {{message["user_email"]}}
                </td>
            </tr>
            <tr>
                <td width="150" style="padding: 10px;">Kullanıcı Telefon</td>
                <td style="padding: 10px;">
                    {{message["user_phone"]}}
                </td>
            </tr>
            <tr>
                <td width="150" style="padding: 10px;">Tip</td>
                <td style="padding: 10px;">
                    {{message["type"]}}
                </td>
            </tr>
            <tr>
                <td width="150" style="padding: 10px;">Konu</td>
                <td style="padding: 10px;">
                    {{message["subject"]}}
                </td>
            </tr>
            <tr>
                <td width="150" style="padding: 10px;">Mesaj</td>
                <td style="padding: 10px;">
                    {{message["message"]}}
                </td>
            </tr>
        </table>
    </div>
    <div class="mesaj_alt" style="width: 100%; height: 30px; line-height: 31px; background: #0552a2; padding: 0 15px; box-sizing: border-box; font-size: 11px; text-align: left;">Bu mesaj  {{"now"|date("d-m-Y H:i")}} Tarihinde otomatik olarak gönderilmiştir. </div>
</div>
