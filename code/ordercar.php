<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<form name="form" method="post" action="ordercar_finish.php">
        
                <div class="form-group2">
                    <i class="fas fa-map-marker-alt"></i>
                    <select id="location", name="location">
                        <option value="" disabled selected>租車地點</option>
                        <option value="台北市">台北</option>
                        <option value="新北市">新北</option>
                        <option value="桃園市">桃園</option>
                        <option value="台中市">台中</option>
                        <option value="台南市">台南</option>
                        <option value="高雄市">高雄</option>
                    </select>
                </div>
                <div class="form-group">
                    <i class="fas fa-calendar-alt"></i>
                    <input type="date" id="pickup-date", name = "ren_startdate">
                    <select id="pickup-time", name="ren_starttime">
                        <option value="8:00">8:00</option>
                        <option value="9:00">9:00</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="12:00">12:00</option>
                        <option value="13:00">13:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                        <option value="17:00">17:00</option>
                        <option value="18:00">18:00</option>
                        <option value="19:00">19:00</option>
                        <option value="20:00">20:00</option>
                    </select>
                </div>
                <div class="form-group">
                    <i class="fas fa-calendar-alt"></i>
                    <input type="date" id="return-date", name = "ren_enddate">
                    <select id="return-time", name = "ren_endtime">
                        <option value="8:00">8:00</option>
                        <option value="9:00">9:00</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="12:00">12:00</option>
                        <option value="13:00">13:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                        <option value="17:00">17:00</option>
                        <option value="18:00">18:00</option>
                        <option value="19:00">19:00</option>
                        <option value="20:00">20:00</option>
                    </select>
                </div>
                <div class="form-group2">
                    <select id="seats" , name = "veh_type">
                        <option value="" disabled selected>車種</option>
                        <option value="轎車">轎車</option>
                        <option value="休旅車">休旅車</option>
						<option value="箱型車">箱型車</option>
                    </select>
                </div>
                <button type="submit">搜尋</button>
            </form>