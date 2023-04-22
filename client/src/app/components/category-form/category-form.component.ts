import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-category-form',
  templateUrl: './category-form.component.html',
  styleUrls: ['./category-form.component.scss'],
})
export class CategoryFormComponent implements OnInit {
  @Input() category: any;
  @Input() submit: () => void = (): void => {};
  @Input() chooseImage: boolean = true;

  constructor() {}

  ngOnInit(): void {}

  onSubmit() {
    this.submit();
  }

  selectImage(event: any) {
    this.category.image = event.target.files[0];
  }
}
