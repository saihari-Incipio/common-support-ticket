<div id="calender-view">
    <span style="display:none">
        <form name="dateChooser">
            <select name="chooseMonth" id="monthchooser">
                <option value="0">January</option>
                <option value="1">February</option>
                <option value="2">March</option>
                <option value="3">April</option>
                <option value="4">May</option>
                <option selected="selected" value="5">June</option>
                <option value="6">July</option>
                <option value="7">August</option>
                <option value="8">September</option>
                <option value="9">October</option>
                <option value="10">November</option>
                <option value="11">December</option>
            </select>
            <select name="chooseYear" id="yearChooser">
                <option value="2012">2012</option>
                <option value="2013">2013</option>
                <option value="2014">2014</option>
                <option selected="selected" value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
            </select>
        </form>
    </span>
    <div id="selected-month-name"> </div>

    <!-- Calender Table View  -->
    <table id="calendarTable" align="left" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <th>Sun</th>
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thu</th>
                <th>Fri</th>
                <th>Sat</th>
            </tr>
        </tbody>
        <tbody id="tableBody"></tbody>
    </table>
    <!-- End Calender Table View  -->
</div>
</div> <!-- content div over -->

<span id="mail-to-send" style="display:none;"></span>