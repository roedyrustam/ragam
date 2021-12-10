<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('frontend/common/head_view');
$this->load->view('frontend/common/header_view');

?>

    <!------main-content------>
    <main class="main-content">

        <section class="page_title">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 d-flex">
                        <div class="content_box">
                            <ul class="bread_crumb text-center">
                                <li class="bread_crumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li class="bread_crumb-item active"> <?php echo $this->lang->line("Country Statistics"); ?></li>
                            </ul>
                            <h1 style="font-size: 38px;"><?php echo $this->lang->line("Country Statistics"); ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="text-center">
                    <br>
                    <img class="banner_ads_728_90" src="<?php echo base_url()."assets/frontend/images/728-90.png"; ?>">
                    <br>
                </div>
                <div class="row">
                    <div class="text-center" style="width: 100%;">
                        <br><br>
                        <input class="form-control form-control-lg" style="background: #f9f9f9" id="myInput" type="text" placeholder="Country Search...">
                        <br>
                    </div>

                    <table class="table table-borderless table-hover table-sm" style="background: #FFFFFF; padding: 3px; border-radius: 6px;">
                        <thead>
                        <tr>
                            <th>Country</th>
                            <th class="text-center">Total Cases</th>
                            <th class="text-center">Today Cases</th>
                            <th class="text-center">Recovered</th>
                            <th class="text-center">Deaths</th>
                            <th class="text-center">Today Deaths</th>
                            <th class="text-center">Active</th>
                            <th class="text-center">Critical</th>
                        </tr>
                        </thead>
                    <?php
                    $i = 1;
                    foreach($countriesList as $country)
                    {
                    ?>

                        <tbody id="myTable">
                        <!--<tr style="cursor: pointer;" onclick="window.location='one_country.php?country=<?php echo html_entity_decode($country->country); ?>';">-->
                        <tr <?php echo html_entity_decode($country->country); ?>>
                            <td><?php echo html_entity_decode($country->country); ?></td>
                            <td class="text-center" style="color: #4a4a4a;"><?php echo html_entity_decode(number_format($country->cases)); ?></td>
                            <td class="text-center" style="color: #4a4a4a;"><?php echo html_entity_decode(number_format($country->todayCases)); ?></td>
                            <td class="text-center" style="color: #00CA11;"><?php echo html_entity_decode(number_format($country->recovered)); ?></td>
                            <td class="text-center" style="color: #FF0000;"><?php echo html_entity_decode(number_format($country->deaths)); ?></td>
                            <td class="text-center" style="color: #FF0000;"><?php echo html_entity_decode(number_format($country->todayDeaths)); ?></td>
                            <td class="text-center"><?php echo html_entity_decode(number_format($country->active)); ?></td>
                            <td class="text-center"><?php echo html_entity_decode(number_format($country->critical)); ?></td>
                        </tr>
                        </tbody>

                    <?php
                    }
                    ?>
                    </table>
                    <p>Source: <a target="_blank" href="https://www.worldometers.info/coronavirus/">www.worldometers.info</a></p>
                </div>
                <br><br>
                <script>
                    $(document).ready(function(){
                        $("#myInput").on("keyup", function() {
                            var value = $(this).val().toLowerCase();
                            $("#myTable tr").filter(function() {
                                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                            });
                        });
                    });
                </script>
                </div>
            </div>
        </section>

    </main>

<?php
$this->load->view('frontend/common/footer_view');
?>