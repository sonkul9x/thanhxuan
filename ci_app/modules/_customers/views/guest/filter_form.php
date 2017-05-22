<div class="section-border search-form" id="ds_2012166308">
    <h3 class="section-title">
        <a class="cm-combo-off cm-combination cm-save-state cm-ss-reverse" id="sw_s_8929ef313c0fd6e43446cc0aa86b70cd">Tìm kiếm</a>
    </h3>


    <div id="s_8929ef313c0fd6e43446cc0aa86b70cd" class="section-body ">	
        <form action="/ha-noi/" name="orders_search_form" method="get">
            <div class="form-field">
                <label>Tổng cộng&nbsp;(VNĐ):</label>
                <input type="text" name="total_from" value="" size="3" style="width: 100px;" class="input-text-short">&nbsp;-&nbsp;<input type="text" name="total_to" value="" size="3" style="width: 100px;" class="input-text-short">
            </div>
            <script type="text/javascript">
                document.write(''); // hide noscript tags
            </script>
            <div class="form-field">
                <label>Thời gian:</label>
                <select name="period" id="period_selects">
                    <option value="A" selected="selected">Tất cả</option>
                    <optgroup label="=============">
                        <option value="D">Hôm nay</option>
                        <option value="W">Tuần này</option>
                        <option value="M">Tháng này</option>
                        <option value="Y">Năm nay</option>
                    </optgroup>
                    <optgroup label="=============">
                        <option value="LD">Hôm qua</option>
                        <option value="LW">Tuần trước</option>
                        <option value="LM">Tháng trước</option>
                        <option value="LY">Năm ngoái</option>
                    </optgroup>
                    <optgroup label="=============">
                        <option value="HH">24 giờ trước</option>
                        <option value="HW">7 ngày trước</option>
                        <option value="HM">30 ngày trước</option>
                    </optgroup>
                    <optgroup label="=============">
                        <option value="C">Khác...</option>
                    </optgroup>
                </select>
            </div>
            <div class="form-field">
                <label>Chọn ngày:</label>
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-calendar cm-external-focus calendar-but valign" rev="f_date" title="Lịch" alt="Lịch"></i></span>
                    <input type="text" id="f_date" name="time_from" class="input-text-medium cm-calendar hasDatepicker" value="" onchange="$('#period_selects').val('C');" size="10">
                </div>
                <script type="text/javascript">
                //<![CDATA[

                var config = {};
                config = {
                    changeMonth: true,
                    duration: 'fast',
                    changeYear: true,
                    numberOfMonths: 1,
                    selectOtherMonths: true,
                    showOtherMonths: true,
                    firstDay: 1,
                    dayNames: ['CN', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'],
                    monthNamesShort: ['Thg 1', 'Thg 2', 'Thg 3', 'Thg 4', 'Thg 5', 'Thg 6', 'Thg 7', 'Thg 8', 'Thg 9', 'Thg 10', 'Thg 11', 'Thg 12'],
                    yearRange: '2010:2014',
                    dateFormat: 'dd/mm/yy'
                };

                if (jQuery.ua.browser == 'Internet Explorer') {
                    $(window).load(function() {
                        $('#f_date').datepicker(config);
                    });
                } else {
                    $('#f_date').datepicker(config);
                }
                //]]>
                </script>	&nbsp;&nbsp;-&nbsp;&nbsp;
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-calendar cm-external-focus calendar-but valign" rev="t_date" title="Lịch" alt="Lịch"></i></span>
                    <input type="text" id="t_date" name="time_to" class="input-text-medium cm-calendar hasDatepicker" value="" onchange="$('#period_selects').val('C');" size="10">
                </div>
                <script type="text/javascript">
                //<![CDATA[

                var config = {};
                config = {
                    changeMonth: true,
                    duration: 'fast',
                    changeYear: true,
                    numberOfMonths: 1,
                    selectOtherMonths: true,
                    showOtherMonths: true,
                    firstDay: 1,
                    dayNames: ['CN', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'],
                    monthNamesShort: ['Thg 1', 'Thg 2', 'Thg 3', 'Thg 4', 'Thg 5', 'Thg 6', 'Thg 7', 'Thg 8', 'Thg 9', 'Thg 10', 'Thg 11', 'Thg 12'],
                    yearRange: '2010:2014',
                    dateFormat: 'dd/mm/yy'
                };

                if (jQuery.ua.browser == 'Internet Explorer') {
                    $(window).load(function() {
                        $('#t_date').datepicker(config);
                    });
                } else {
                    $('#t_date').datepicker(config);
                }
                //]]>
                </script>		
                <label for="t_date" class="cm-custom check_valid_search_date"></label>
                <script type="text/javascript">
                    function fn_check_valid_search_date() {
                        var f_date = document.getElementById('f_date').value;
                        var t_date = document.getElementById('t_date').value;

                        var array_f_date = f_date.split("/");
                        var array_t_date = t_date.split("/");

                        f_date = array_f_date[2] + '' + array_f_date[1] + '' + array_f_date[0];
                        t_date = array_t_date[2] + '' + array_t_date[1] + '' + array_t_date[0];

                        if (f_date != '' && t_date != '' && f_date > t_date) {
                            return '_end_date_cannot_less_than_start_date';
                        }
                        return true;
                    }
                </script>	
            </div>
            <script type="text/javascript" src="/js/period_selector.js"></script>
            <script type="text/javascript">
                //<![CDATA[
                $('#period_selects').cePeriodSelector({
                    from: 'f_date',
                    to: 't_date'
                });
                //]]>
            </script>
            <div class="form-field">
                <label>Mã đơn hàng:</label>
                <input type="text" name="order_id" value="" size="10" class="input-text">
            </div>
            <div class="buttons-container" style="text-align:left;padding-left:170px">
                <span class="button-submit"><input type="submit" name="dispatch[orders.search]" value="Tìm kiếm"></span>
            </div>
        </form></div>
</div>