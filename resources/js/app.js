import './bootstrap';

import { AdminLte } from './adminLte/AdminLTE';
import bsCustomFileInput from 'bs-custom-file-input';
import { IndexController } from './controllers/IndexController';

$(document).ready(function () {
    bsCustomFileInput.init()
  });

new AdminLte;
new IndexController;