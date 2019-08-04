var Responses = function (xhr, url, textStatus, dataType) {
       this.url = url;
       this.status = xhr.status;
       this.response = xhr.responseJSON || xhr.responseText;
       //Textstatus = "timeout", "error", "abort", "parsererror", "application"
       this.textStatus = textStatus;
       this.dataType = dataType;
       this.xhr = xhr;

       var responseType = this.header('content-type');

       if ((!dataType || dataType === 'json') && responseType && responseType.indexOf('json') > -1) {
           $.extend(this, this.response);
       } else if (dataType) {
           this[dataType] = this.response;
       }
   };

   Response.prototype.header = function (key) {
       return this.xhr.getResponseHeader(key);
   };

   Response.prototype.setSuccess = function (data) {
       this.data = data;
       return this;
   };

   Response.prototype.setError = function (errorThrown) {
       try {
           this.error = JSON.parse(this.response);
       } catch (e) {/!* Nothing todo... *!/
       }

       this.error = this.error || {};
       this.errorThrown = errorThrown;
       this.validationError = (this.status === 400);
       return this;
   };

   Response.prototype.isError = function () {
       return this.status >= 400;
   };

   Response.prototype.getLog = function () {
       var result = $.extend({}, this);

       if (this.response && object.isString(this.response)) {
           result.response = this.response.substr(0, 500)
           result.response += (this.response.length > 500) ? '...' : '';
       }

       if (this.html && object.isString(this.html)) {
           result.html = this.html.substr(0, 500)
           result.html += (this.html.length > 500) ? '...' : '';
       }

       return result;
   };