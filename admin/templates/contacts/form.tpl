<div class="col-sm-12">
    <table class="table table-bordered dataTables-example-">
        <thead>
        <th>Subject</th>
        <th>Message</th>
        <th>User</th>
        <th>Options</th>
        </thead>
        <tbody>
        <tr>
            <td>{{data.subject}} </td>
            <td>{{data.message}} </td>
            <td>{{data.user_name}} </td>
            <td>{{data.options}} </td>
        </tr>
        </tbody>
    </table>
</div>
<hr>
{% if data.status == 1 %}
<div class="col-sm-12">
    <table class="table table-bordered dataTables-example-">
        <thead>
        <th>Subject</th>
        <th>Message</th>
        <th>from</th>
        </thead>
        <tbody>
        <tr>
            <td>Replyed</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>{{data.cevap_konu}} </td>
            <td>{{data.cevap_mesaj}} </td>
            <td>{{data.tarafindan}} </td>
        </tr>
        </tbody>
    </table>
</div>
{% endif %}
<div class="col-sm-12">
    <div class="form-group row">
        <div class="col-sm-3">
            <label class="col-sm-12 col-form-label">Subject* </label>
        </div>
        <div class="col-sm-9">
            <input type="text" placeholder="Subject" name="konu" class="form-control" required autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-3">
            <label class="col-sm-12 col-form-label">Message* </label>
        </div>
        <div class="col-sm-9">
            <textarea name="mesaj" placeholder="Message" class="form-control" data-parsley-id="13311"></textarea>
        </div>
    </div>
</div>
