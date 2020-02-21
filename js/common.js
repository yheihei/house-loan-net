$(function(){
  'use strict';

  var sbi = {
    hendo: 0.457,
    y10:   0.860,
    y20:   1.360,
    y30:   1.440,
  };
  var sony = {
    hendo: 0.807,
    y10:   1.010,
    y20:   1.570,
    y30:   1.694,
  };
  var eon = {
    hendo: 0.57,
    y10:   0.69,
  };
  var risona = {
    hendo:  0.569,
    y10:    0.450,
    y20:    2.344,
  };


  
  risona.rhendo = risona.hendo + 0.2;
  risona.ry10   = risona.y10 + 0.2;
  risona.ry20   = risona.y20 + 0.2;

  $('#js_side1_rank1').find('span').text(float2(sbi.y30));
  $('#js_side1_rank2').find('span').text(float2(sony.y30));
  $('#js_side1_rank3').find('span').text(float2(eon.y10));

  $('#js_side2_rank1').find('span').text(float2(sbi.y10));
  $('#js_side2_rank2').find('span').text(float2(eon.y10));
  $('#js_side2_rank3').find('span').text(float2(sony.y10));

  if($('#js_compare_table').get(0)){
    //sbi
    $('#js_sbi_hendo').text(float2(sbi.hendo));
    $('#js_sbi_rhendo').text(float2(sbi.hendo));
    $('#js_sbi_y10').text(float2(sbi.y10));
    $('#js_sbi_ry10').text(float2(sbi.y10));
    $('#js_sbi_y20').text(float2(sbi.y20));
    $('#js_sbi_ry20').text(float2(sbi.y20));

    //sony
    $('#js_sony_hendo').text(float2(sony.hendo));
    $('#js_sony_rhendo').text(float2(sony.hendo));
    $('#js_sony_y10').text(float2(sony.y10));
    $('#js_sony_ry10').text(float2(sony.y10));
    $('#js_sony_y20').text(float2(sony.y20));
    $('#js_sony_ry20').text(float2(sony.y20));

    //eon
    $('#js_eon_hendo').text(float2(eon.hendo));
    $('#js_eon_rhendo').text(float2(eon.hendo));
    $('#js_eon_y10').text(float2(eon.y10));
    $('#js_eon_ry10').text(float2(eon.y10));

    //risona
    $('#js_risona_hendo').text(float2(risona.hendo));
    $('#js_risona_rhendo').text(float2(risona.hendo));
    $('#js_risona_y10').text(float2(risona.y10));
    $('#js_risona_ry10').text(float2(risona.y10));
    $('#js_risona_y20').text(float2(risona.y20));
    $('#js_risona_ry20').text(float2(risona.y20));

  }

  function float2(v){
    var num_obj = new Number(v);
    return num_obj.toFixed(3);
  }
});