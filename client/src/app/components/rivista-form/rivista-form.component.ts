import { Component, Input, OnInit } from '@angular/core';
import { AngularEditorConfig } from '@kolkov/angular-editor';

@Component({
  selector: 'app-rivista-form',
  templateUrl: './rivista-form.component.html',
  styleUrls: ['./rivista-form.component.scss'],
})
export class RivistaFormComponent implements OnInit {
  @Input() rivista: any = {
    text: ''
  };
  @Input() categories: any;
  @Input() submit: () => void = (): void => {};

  editorConfig: AngularEditorConfig = {
    editable: true,
    spellcheck: true,
    translate: 'no',
    sanitize: false,
    toolbarHiddenButtons: [
      ['superscript', 'subscript'],
      ['fontSize', 'fontName'],
      ['textColor', 'backgroundColor', 'insertImage', 'insertVideo']
    ],
  };

  constructor() {}

  ngOnInit(): void {}

  onSubmit() {
    this.submit();
  }

  selectImage(event: any) {
    this.rivista.image = event.target.files[0];
  }
}
