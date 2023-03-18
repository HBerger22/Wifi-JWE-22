
        <section class="login">
            <a href="javascript:history.back()">Zurück</a>
            <form action="#" method="post">
                <input type="text" name="ben" id="ben" value="<?php if(isset($_POST["ben"])){echo $_POST["ben"];} ?>">
                <input type="password" name="p_wort" id="p_wort">
                <input type="submit" value="submit">
            </form>
        </section>
