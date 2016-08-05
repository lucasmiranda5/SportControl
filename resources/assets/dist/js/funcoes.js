function number_format (number, decimals, dec_point, thousands_sep) {

  number = (number + '').replace(/[^0-9+\-Ee.]/g, '');

  var n = !isFinite(+number) ? 0 : +number,

    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),

    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,

    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,

    s = '',

    toFixedFix = function (n, prec) {

      var k = Math.pow(10, prec);

      return '' + Math.round(n * k) / k;

    };

  // Fix for IE parseFloat(0.55).toFixed(0) = 0;

  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');

  if (s[0].length > 3) {

    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);

  }

  if ((s[1] || '').length < prec) {

    s[1] = s[1] || '';

    s[1] += new Array(prec - s[1].length + 1).join('0');

  }

  return s.join(dec);

}
function moedaParaNumero(valor){
        return isNaN(valor) == false ? parseFloat(valor) :   parseFloat(valor.replace("R$","").replace(".","").replace(",","."));
}
function numeroParaMoeda(n, c, d, t){
        c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}