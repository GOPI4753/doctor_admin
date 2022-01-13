(function ($) {
  window.addEventListener("DOMContentLoaded", function () {
    var upload_image_file = document.getElementById("dr_uploadfile");
    if (upload_image_file) {
      upload_image_file.addEventListener("change", function (e) {
        var files = e.target.files;
        if (files && files.length > 0) {
          $.each(files, function (key, value) {
            var reader;
            var file;
            var URL;
            file = files[key];
            if (URL) {
              done(URL.createObjectURL(file));
            } else if (FileReader) {
              reader = new FileReader();
              reader.onload = function (e) {
                var html = "";
                var myname = "";
                var myname_arr = value.name.split(/\.(?=[^\.]+$)/);
                if (typeof myname_arr === "object" && myname_arr !== null) {
                  myname = myname_arr[0];
                }
                html =
                  '<div class="image-main-wrapper"><img class="image-base64" src="' +
                  reader.result +
                  '" width="300" height="300" alt="' +
                  value.name +
                  '"><div class="image-meta-wrapper"><input type="text" class="image-name" value="' +
                  myname +
                  '" readonly/><span class="image-filter">Apply Filter</span><span class="image-rename">Rename</span><span class="image-delele">Delete</span></div></div>';
                $(".dr-upload-image-wrap").append(html);
              };
              reader.readAsDataURL(file);
            }
          });
        }
      });
    }
  });
  //webcam
  $(document).on("click", ".dr-takephoto", function () {
    $(".dr-snap").show();
    Webcam.set({
      width: 640,
      height: 480,
      image_format: "jpeg",
      jpeg_quality: 90,
    });
    Webcam.attach(".dr-webcan-image-wrap");
  });

  $(document).on("click", ".dr-snap", function () {
    Webcam.snap(function (data_uri) {
      var d = new Date();
      var mon = d.getMonth() + 1;
      var current_date =
        "IMG_" +
        d.getFullYear() +
        "" +
        mon +
        "" +
        d.getDate() +
        "_" +
        d.getHours() +
        "" +
        d.getMinutes() +
        "" +
        d.getSeconds();
      var html =
        '<div class="image-main-wrapper"><img class="image-base64" src="' +
        data_uri +
        '" width="300" height="300" alt="' +
        current_date +
        '"><div class="image-meta-wrapper"><input type="text" class="image-name" value="' +
        current_date +
        '" readonly/><span class="image-filter">Apply Filter</span><span class="image-rename">Rename</span><span class="image-delele">Delete</span></div></div>';
      $(".dr-upload-image-wrap").append(html);
    });
  });
  //
  $(document).on("click", ".image-delele", function () {
    $(this).closest(".image-main-wrapper").remove();
  });
  //
  $(document).on("click", ".image-rename", function () {
    $(this)
      .closest(".image-main-wrapper")
      .find(".image-name")
      .attr("readonly", false);
  });
  //patient record..
  $(document).on("change", ".patient_records", function () {
    var data_url = $(this).find("option:selected").data("url");
    if (data_url != undefined) {
      window.location.href = data_url;
    }
  });
  //
  $(document).on("change", ".tech_records", function () {
    var tech_id = $(this).val();
    var homeurl = "https://droroscope.com/admin_2019";
    // var homeurl = "http://doctor_admin.com/";
    // var homeurl = "http://doctor_admin.com/doctor_admin/";
    if (tech_id != "-1") {
      $.ajax({
        type: "POST",
        url: "patient_info.php",
        data: "tech_id=" + tech_id,
        success: function (data) {
          if (data != 0) {
            var patient_records_data = $.parseJSON(data);
            var patient_records_arr = patient_records_data["resource"];
            if (patient_records_arr.length > 1) {
              var option_str =
                "<option value='-1'>---Select patient---</option>";
              $.each(patient_records_arr, function (index, value) {
                option_str +=
                  '<option data-url = "' +
                  homeurl +
                  "/includes/login.php?patient_id=" +
                  value.id +
                  "&tech_id=" +
                  tech_id +
                  '" value="' +
                  value.id +
                  '">' +
                  value.name +
                  "</option>";
              });
              $(".patient_records").empty().append(option_str);
            } else {
              $(".patient_records")
                .empty()
                .append("<option value='-1'>---Select patient---</option>");
            }
          } else {
            $(".patient_records")
              .empty()
              .append("<option value='-1'>---Select patient---</option>");
          }
        },
      });
    }
  });
  //uploading.
  $(document).on("click", ".sumit_form", function () {
    var techid = $(".dr_tech_id").data("tech_id");
    var api_key = $(".login-main").data("api-key");
    var sess_kot = $(".login-main").data("sess-kot");
    var id = $(".dr_id").data("id");
    var name = $(".dr_name").val();
    var email = $(".dr_email").val();
    var phone = $(".dr_phone").val();
    var address = $(".dr_address").val();
    var description = $(".dr_description").val();
    var isAnyPreviousHistory = $(
      "input[name=dr_isAnyPreviousHistory]:checked"
    ).val();
    //
    var isHabitOfSmoking = $(".dr_isHabitOfSmoking").prop("checked") ? 1 : 0;
    var isHabitOfTobacco = $(".dr_isHabitOfTobacco").prop("checked") ? 1 : 0;
    var isHabitOfAlcohol = $(".dr_isHabitOfAlcohol").prop("checked") ? 1 : 0;
    //
    var durationSmoking_val = $(".dr_durationSmoking").val();
    var durationTobacco_val = $(".dr_durationTobacco").val();
    var durationAlcohol_val = $(".dr_durationAlcohol").val();
    //
    var durationSmoking_span = $(".dr_durationSmoking_span").val();
    var durationTobacco_span = $(".dr_durationTobacco_span").val();
    var durationAlcohol_span = $(".dr_durationAlcohol_span").val();
    //
    var durationAlcohol = durationSmoking_val + " " + durationSmoking_span;
    var durationTobacco = durationTobacco_val + " " + durationTobacco_span;
    var durationSmoking = durationAlcohol_val + " " + durationAlcohol_span;
    //2nd half
    var dr_pain = $(".dr_pain").prop("checked") ? 1 : 0;
    var dr_redness = $(".dr_redness").prop("checked") ? 1 : 0;
    var dr_white_patch = $(".dr_white_patch").prop("checked") ? 1 : 0;
    var dr_red_and_white_patch = $(".dr_red_and_white_patch").prop("checked")
      ? 1
      : 0;
    var dr_growth = $(".dr_growth").prop("checked") ? 1 : 0;
    var dr_swelling = $(".dr_swelling").prop("checked") ? 1 : 0;
    var dr_ulcers = $(".dr_ulcers").prop("checked") ? 1 : 0;
    var dr_unable_to_open_the_mouth = $(".dr_unable_to_open_the_mouth").prop(
      "checked"
    )
      ? 1
      : 0;
    var dr_pigmentation_dark_area = $(".dr_pigmentation_dark_area").prop(
      "checked"
    )
      ? 1
      : 0;
    var dr_blanching_diascopy = $(".dr_blanching_diascopy").prop("checked")
      ? 1
      : 0;
    var dr_burning = $(".dr_burning").prop("checked") ? 1 : 0;
    var dr_anterior_front_region = $(".dr_anterior_front_region").prop(
      "checked"
    )
      ? 1
      : 0;
    var dr_posterior_back_region = $(".dr_posterior_back_region").prop(
      "checked"
    )
      ? 1
      : 0;
    //3rd
    var dr_site_left = $(".dr_site_left").prop("checked");
    var dr_site_right = $(".dr_site_right").prop("checked");
    var dr_site = 0;
    if (dr_site_left && dr_site_right) {
      dr_site = 3;
    } else if (dr_site_right) {
      dr_site = 1;
    } else if (dr_site_left) {
      dr_site = 2;
    }
    //
    var dr_tongue_left = $(".dr_tongue_left").prop("checked");
    var dr_tongue_right = $(".dr_tongue_right").prop("checked");
    var dr_tongue = 0;
    if (dr_tongue_left && dr_tongue_right) {
      dr_tongue = 3;
    } else if (dr_tongue_right) {
      dr_tongue = 1;
    } else if (dr_tongue_left) {
      dr_tongue = 2;
    }
    //
    var dr_cheek_right = $(".dr_cheek_right").prop("checked");
    var dr_cheek_left = $(".dr_cheek_left").prop("checked");
    var dr_cheek = 0;
    if (dr_cheek_right && dr_cheek_left) {
      dr_cheek = 3;
    } else if (dr_cheek_left) {
      dr_cheek = 2;
    } else if (dr_cheek_right) {
      dr_cheek = 1;
    }
    //
    var dr_palate_right = $(".dr_palate_right").prop("checked");
    var dr_palate_left = $(".dr_palate_left").prop("checked");
    var dr_palate = 0;
    if (dr_palate_right && dr_palate_left) {
      dr_palate = 3;
    } else if (dr_palate_left) {
      dr_palate = 2;
    } else if (dr_palate_right) {
      dr_palate = 1;
    }
    //
    var dr_gums_right = $(".dr_gums_right").prop("checked");
    var dr_gums_left = $(".dr_gums_left").prop("checked");
    var dr_gums = 0;
    if (dr_gums_right && dr_gums_left) {
      dr_gums = 3;
    } else if (dr_gums_left) {
      dr_gums = 2;
    } else if (dr_gums_right) {
      dr_gums = 1;
    }
    //
    var dr_lips_right = $(".dr_lips_right").prop("checked");
    var dr_lips_left = $(".dr_lips_left").prop("checked");
    var dr_lips = 0;
    if (dr_lips_right && dr_lips_left) {
      dr_lips = 3;
    } else if (dr_lips_left) {
      dr_lips = 2;
    } else if (dr_lips_right) {
      dr_lips = 1;
    }

    var patientinfodata = JSON.stringify({
      resource: [
        {
          techid: techid,
          name: name,
          email: email,
          phone: phone,
          address: address,
          description: description,
          durationAlcohol: durationAlcohol,
          durationTobacco: durationTobacco,
          durationSmoking: durationSmoking,
          isAnyPreviousHistory: isAnyPreviousHistory,
          isHabitOfAlcohol: isHabitOfSmoking,
          isHabitOfTobacco: isHabitOfTobacco,
          isHabitOfSmoking: isHabitOfAlcohol,
        },
      ],
      ids: [id],
      filter: "string",
      params: ["string"],
    });
    var patientrecorddata = JSON.stringify({
      resource: [
        {
          patient_id: id,
          pain: dr_pain,
          redness: dr_redness,
          whitepatch: dr_white_patch,
          redandwhitepatch: dr_red_and_white_patch,
          growth: dr_growth,
          swelling: dr_swelling,
          ulcers: dr_ulcers,
          unable_to_open_the_mouth: dr_unable_to_open_the_mouth,
          anterior: dr_anterior_front_region,
          posterior: dr_posterior_back_region,
          site: dr_site,
          tongue: dr_tongue,
          cheek: dr_cheek,
          palate: dr_palate,
          gums: dr_gums,
          lips: dr_lips,
          pigmentation: dr_pigmentation_dark_area,
          blanching: dr_blanching_diascopy,
          burning: dr_burning,
        },
      ],
      ids: [
        {
          patient_id: id,
        },
      ],
      filter: "string",
      params: ["string"],
    });
    //ajax calling
    var res = false;
    if (id) {
      imageurls(id, api_key, sess_kot);
      //1st call
      var patientinfo = new XMLHttpRequest();
      patientinfo.withCredentials = true;
      patientinfo.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
          res = true;
        }
      });
      patientinfo.open(
        "PUT",
        "https://api.droroscope.com/api/v2/mysqldb/_table/patient_info"
      );
      patientinfo.setRequestHeader("Content-Type", "application/json");
      patientinfo.setRequestHeader("X-DreamFactory-Api-Key", api_key);
      patientinfo.setRequestHeader("X-DreamFactory-Session-Token", sess_kot);
      patientinfo.setRequestHeader("cache-control", "no-cache");
      patientinfo.send(patientinfodata);
      //2nd call
      var patientrecord = new XMLHttpRequest();
      patientrecord.withCredentials = true;
      patientrecord.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
          res = true;
        }
      });
      patientrecord.open(
        "PUT",
        "https://api.droroscope.com/api/v2/mysqldb/_table/patient_record"
      );
      patientrecord.setRequestHeader("Content-Type", "application/json");
      patientrecord.setRequestHeader("X-DreamFactory-Api-Key", api_key);
      patientrecord.setRequestHeader("X-DreamFactory-Session-Token", sess_kot);
      patientrecord.setRequestHeader("cache-control", "no-cache");
      patientrecord.send(patientrecorddata);
    }
    setTimeout(function () {
      res ? alert("Info updated successfully!") : alert("Info not updated!");
      location.reload();
    }, 3000);
  });
  function imageurls(patientid, api_key, sess_kot) {
    $(".image-main-wrapper").each(function (index, value) {
      var image_base64 = $(this)
        .find(".image-base64")
        .attr("src")
        .replace(/^data\:image\/\w+\;base64\,/, "");
      var image_name = $(this).find(".image-name").val();
      var data = JSON.stringify({
        resource: [
          {
            name: image_name + ".jpg",
            type: "file",
            is_base64: true,
            content: image_base64,
          },
        ],
      });
      var imagefileupload = new XMLHttpRequest();
      imagefileupload.withCredentials = true;
      imagefileupload.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
          if (JSON.parse(this.responseText).resource[0].name) {
            var imageurldata = JSON.stringify({
              resource: [
                {
                  url: "./" + JSON.parse(this.responseText).resource[0].name,
                  patient_id: patientid,
                  area: 0,
                },
              ],
            });
            var imageurl = new XMLHttpRequest();
            imageurl.withCredentials = true;
            imageurl.addEventListener("readystatechange", function () {
              if (this.readyState === 4) {
              }
            });
            imageurl.open(
              "POST",
              "https://api.droroscope.com/api/v2/mysqldb/_table/imageurls"
            );
            imageurl.setRequestHeader("X-DreamFactory-Api-Key", api_key);
            imageurl.setRequestHeader("X-DreamFactory-Session-Token", sess_kot);
            imageurl.setRequestHeader("Content-Type", "application/json");
            imageurl.setRequestHeader("cache-control", "no-cache");
            imageurl.send(imageurldata);
          }
        }
      });
      imagefileupload.open("POST", "https://api.droroscope.com/api/v2/files");
      imagefileupload.setRequestHeader("X-DreamFactory-Api-Key", api_key);
      imagefileupload.setRequestHeader(
        "X-DreamFactory-Session-Token",
        sess_kot
      );
      imagefileupload.setRequestHeader("Content-Type", "application/json");
      imagefileupload.setRequestHeader("cache-control", "no-cache");
      imagefileupload.send(data);
    });
  }
})(jQuery);
