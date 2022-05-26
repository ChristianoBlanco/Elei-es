 <div class="row" id="liberar">
   <?php
      $rs = mysqli_query($con, "select * from cabines limit 0,10");
      if(mysqli_num_rows($rs) > 0){
          while($rw = mysqli_fetch_assoc($rs)){
   ?>
    <div class="col-md-6">
    <div class="form-group">
      <div class="col-md-6">
        <label class="control-label">IP da máquina</label>
        <div class="cabines input-group">
          <input type="number" name="ip" value="<?php print $rw['ip'] ?>" class="form-control">
          <span class="input-group-btn"> <a href="javascript:void(0)" class="btn btn-success lalocar" valor="<?php print $rw['cabine'] ?>">Cabine <?php print $rw['cabine'] ?></a> </span>
        </div>
     </div>
     <div class="col-md-6">
       <a href="javascript:void(0)" class="btn btn-info cab" cabine="<?php print $rw['cabine'] ?>" ip="<?php print $rw['ip'] ?>" style="margin-top: 25px;">Liberar</a>
     </div>
    </div>
    </div>
    <?php
    }
  }