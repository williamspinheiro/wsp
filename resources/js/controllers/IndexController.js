import { DataTableController } from './DataTableController';
import { DualBoxController } from './DualBoxController';
import { FormController } from './FormController';
import { ImgPreviewController } from './ImgPreviewController';
import { MaskController } from './MaskController';
import { MenuController } from './MenuController';
import { NotificationController } from './NotificationController';
import { Select2Controller } from './Select2Controller';
import { SpinnerController } from './SpinnerController';
import { ThemeController } from './ThemeController'

export class IndexController {

    constructor() {

        new DataTableController();
        new DualBoxController('.permissions-list');
        new FormController();
        new ImgPreviewController;
        new MaskController('.mask');
        new MenuController;
        new NotificationController();
        new Select2Controller('.select-ajax');
        new SpinnerController;
        new ThemeController();
    }
}