import { Injectable } from '@angular/core';
import { NgxSpinnerService } from 'ngx-spinner';

@Injectable({
  providedIn: 'root',
})
export class BusyService {
  constructor(private spinner: NgxSpinnerService) {}

  busy() {
    this.spinner.show();
  }

  idle() {
    this.spinner.hide();
  }
}
