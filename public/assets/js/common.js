common = typeof(window.common) === 'object' ? window.common : {};

common.getDataInBlock  = function (id, data) {
  var blockEl = document.getElementById(id);
  if (!blockEl) {
    return {};
  }
  data = data || {};
  var listInput = blockEl.querySelectorAll("input, select, textarea");
  if (window.NodeList && !NodeList.prototype.forEach) {
    NodeList.prototype.forEach = Array.prototype.forEach;
  }
  var setData = function (d, ks, v, i) {
    if (i === undefined) {
      i = 0;
    }
    if (typeof ks === 'string') {
      ks = ks.split(/\[/).map(function(v) {
        return v.replace("]", '');
      });
    }
    if (ks.length - 1 > i) {
      var index = ks[i];
      if (index === "") {
        index = d.length;
      }
      if (d[index] === undefined) {
        d[index] = ks[i + 1] === "" ? [] : {};
      }
      setData(d[index], ks, v, i + 1);
    } else {
      if (Array.isArray(d)) {
        d.push(v);
      } else {
        d[ks[i]] = v;
      }
    }
  }
  listInput.forEach(function (el, i) {
    if (el.tagName.toUpperCase() === 'INPUT') {
      if (el.type === 'checkbox') {
        if (el.checked) {
          setData(data, el.name, el.value);
        }
      } else if (el.type !== "radio" || (el.type === "radio" && el.checked)) {
        setData(data, el.name, el.value);
      }
    } else {
      setData(data, el.name, el.value);
    }
  });
  return data;
};

// start grid =======================
common.grid  = typeof(common.grid) === 'object' ? common.grid : {};

common.grid.simpleAjaxSearchAfter = function () {};

common.grid.resetSearchFormBtn = function(formId) {
  $('.grid-option-where-reset').val('');
  $(formId).submit();
}

common.grid.simpleAjaxSearch = function (el, id, href, isPaging) {
  var data;
  if (!isPaging) {
    data = common.getDataInBlock(id + "__search");
    data[id + '__search_perPage'] = $("#" + id + "__search_perPage").val();
  } else {
    var url = new URL(href);
    url.searchParams.set(id + '__search_perPage', $("#" + id + "__search_perPage").val());
    if (el.tagName === 'SELECT') {
      url.searchParams.set('page', 1);
    }
    href = url.href;
  }

  $.ajax({
    url: href,
    data: isPaging ? null : data,
    method: 'get',
    success: function(html) {
      $("#" + id + "__result").html(html);
      $("#" + id + "__result li.page-item:not(.disabled) a").each(function (i, el) {
        var $el = $(el);
        var h = $el.attr('href');
        $el.attr('href', 'javascript:void(0);')
          .click(function (el) {
            common.grid.simpleAjaxSearch(el, id, h, true);
          })
      });

      common.grid.simpleAjaxSearchAfter(el);
    }
  })
}

common.grid.changePageToSubmitInit = function (formId, action) {
  $("#" + formId + " li.page-item:not(.disabled) a")
    .attr('href', 'javascript:void(0);')
    .click(function () {
      $('#grid_page').val($(this).data('page'))
      $("#" + formId)
        .attr('action', action)
        .submit()
    })
}
common.grid.changeThOrderByToSubmitInit = function(formId, action) {
  var selector = '#' + formId + ' th[aria-sort]';
  $(selector).attr('href', 'javascript:void(0);').click(function() {
    var transformSearch = JSON.parse($('#' + formId + ' #grid_transform_search').val());
    transformSearch['orderBy'] = $(this).data('order_by');
    $('#' + formId + ' #grid_transform_search').val(JSON.stringify(transformSearch));
    $('#' + formId).attr('action', action).submit();
  });
};

common.grid.changeLinkToSubmitInit = function (formId) {
  var selector = "#" + formId + " a.grid-transform-link";
  $(selector)
    .attr('href', 'javascript:void(0);')
    .click(function () {
      $("#" + formId + ' #grid_page').remove();
      $("#" + formId + ' #grid_transform_search').val(JSON.stringify($(this).data('transform_search')));
      $("#" + formId + ' #grid_action').val(JSON.stringify($(this).data('action')));
      $("#" + formId)
        .attr('action', $(this).data('href'))
        .submit()
    })
}

common.grid.distinctEnterKeyupKeypressFlag = 0;
common.grid.distinctEnterKeyupKeypress = function () {
  if (common.grid.distinctEnterKeyupKeypressFlag === 1) {
    common.grid.distinctEnterKeyupKeypressFlag = 0;
    return true;
  }
  common.grid.distinctEnterKeyupKeypressFlag = 1;
  return false;
}

common.grid.searchByChangeInputDataInit = function (formOrContainId, searchBtnId) {
  $('#' + formOrContainId + ' input[type="text"].grid-submit').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13 && common.grid.distinctEnterKeyupKeypress()) {
      e.preventDefault();
      if (searchBtnId) {
        $("#" + searchBtnId).trigger('click');
      } else {
        $("#" + formOrContainId).submit();
      }
    }
  });
  $('#' + formOrContainId + ' input[type="text"].grid-submit.datetime,' +
    '#' + formOrContainId + ' select.grid-submit,' +
    '#' + formOrContainId + ' input[type="checkbox"].grid-submit')
    .on('change', function(e) {
      if (searchBtnId) {
        $("#" + searchBtnId).trigger('click');
      } else {
        $("#" + formOrContainId).submit();
      }
    });
}

common.grid.toggleCheckboxSelection = function(el) {
    var boxes = $(el).parents('table').find('tbody').find('input[type=checkbox]');
    var checkAll = $(el).prop('checked');
    boxes.each(function() { $(this).prop('checked', checkAll); });
};
// end grid =======================

common.processData = typeof(common.processData) === 'object' ? common.processData : {};
common.processData.afterReadOk = function() {return true};
common.processData.afterReadErr = function() {return true};
common.processData.afterSaveOk = function() {return true};
common.processData.afterSaveErr = function() {return true};

common.processData.read = function (el, idContain, url, data, idDataContain) {
  if (idDataContain !== undefined) {
    data = common.getDataInBlock(idDataContain, data);
  }
  $.ajax({
    url: url,
    data: data,
    method: 'get',
    success: function(res) {
      if (common.processData.afterReadOk(res, data)) {
        $("#" + idContain).html(res);
      }
    },
    error: function (res) {
      if (common.processData.afterReadErr(res, data)) {
        alert(res.statusText);
      }
    }
  })
}

common.processData.save = function (el, idContain, url, data, idDataContain, loading) {
  if (idDataContain !== undefined) {
    data = common.getDataInBlock(idDataContain, data);
  }
  spinnerLoading = loading;
  $.ajax({
    url: url,
    data: data,
    method: 'post',
    success: function(res, textStatus, xhr) {
      if (common.processData.afterSaveOk(res, data, xhr)) {
        window.location.reload();
      }
    },
    error: function (res) {
      if (common.processData.afterSaveErr(res, data)) {
        if (res.status === 400) {
          $("#" + idContain).html(res.responseText);
        } else {
          alert(res.statusText);
        }
      }
    }
  })
}

common.processData.saveCallback = function (el, idContain, url, data, idDataContain, callbackOk, callbackErr, loading = false) {
  if (callbackOk) {
    var oldOk = common.processData.afterSaveOk;
    common.processData.afterSaveOk = function (res, data, xhr) {
      callbackOk(res, data, xhr);
      common.processData.afterSaveOk = oldOk
    };
  }
  if (callbackErr) {
    var oldErr = common.processData.afterSaveErr;
    common.processData.afterSaveErr = function (res, data) {
      callbackErr(res, data);
      common.processData.afterSaveErr = oldErr
    };
  }
  common.processData.save(el, idContain, url, data, idDataContain, loading);
}
