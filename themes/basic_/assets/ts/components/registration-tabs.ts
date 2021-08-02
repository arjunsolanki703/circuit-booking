export class regTabs {
  header: object;
  tabs: object;
  activeTab: number;

  constructor(header: object, tabs: object) {
    this.header = header;
    this.tabs = tabs;
    // by default on init
    this.activeTab = 0;

    // set active tab
    this._setTabActive(this.activeTab);
    // hax for stupid jquery
    let that = this;
    // register click event
    $(header).find('.step-header').on('click', function() {
      const index = $(this).index();

      if (index > 0) {
        that._openTab(index);
      } else {
        that._setTabActive(0);
      }
    });
  };

  _openTab = (openIndex: number) => {
    let allTabsValid = true;

    // hax for stupid jquery
    let that = this;
    $(this.tabs).find('.step').each(function(index) {
      if (index < openIndex) {
        allTabsValid = that._checkTab(index);
      }

      if (allTabsValid) {
        that._setTabActive(openIndex);
      }
    });
  };

  _checkTab = (index: number) => {
    const tab = $(this.tabs).eq(index);

    // check if all required inputs filled
    // TODO: input validation
    if (1) {
      this._setTabDone(index);
      return true;
    } else {
      this._setTabError(index);
      return false;
    }
  };

  _setTabDone = (index: number) => {
    $(this.header).find('.step-header').eq(index).removeClass('active error').addClass('done');
  };

  _setTabError = (index: number) => {
    $(this.header).find('.step-header').eq(index).removeClass('active done').addClass('error');
  };

  _setTabActive = (index: number) => {
    this._setHeaderActive(index);
    this._setContentActive(index);

    this.activeTab = index;
  };

  _setHeaderActive = (index: number) => {
    $(this.header).find('.step-header').removeClass('active').eq(index).removeClass('done error').addClass('active');
  };

  _setContentActive = (index: number) => {
    $(this.tabs).find('.step').removeClass('active').eq(index).addClass('active');
  };
}

$(document).ready(function() {
  const header = $('#steps-header');
  const content = $('#steps-content');

  if (header.length && content.length) {
    const tabs = new regTabs(header, content);
  }
});