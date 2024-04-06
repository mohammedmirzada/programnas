<select class="_FourText _Padd6 _selectSpinner _font14" id="country" name="country">
   <option value="" disabled>Country&Territory</option>
   <?php
   $countries_options = '';
   $join = db::connect();
   $sql = mysqli_query($join,"SELECT * FROM countries");
   while ($row = mysqli_fetch_assoc($sql)) {
      if (session_exists('user')) {
         if ($row["name"] == $user->data()->country) {
            $countries_options .= '<option value="'.$row["name"].'" selected>'.$row["name"].'</option>';
         }else{
            $countries_options .= '<option value="'.$row["name"].'">'.$row["name"].'</option>';
         }
      }else{
         if ($row["name"] == "Free Kurdistan") {
            $countries_options .= '<option selected value="'.$row["name"].'">'.$row["name"].'</option>';
         }else{
            $countries_options .= '<option value="'.$row["name"].'">'.$row["name"].'</option>';
         }
      }
   }
   echo $countries_options;
   ?>
</select>