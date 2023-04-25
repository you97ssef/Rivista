import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { CategoryService } from 'src/app/services/category.service';
import { MediaService } from 'src/app/services/media.service';

@Component({
  selector: 'app-new-category',
  templateUrl: './new-category.component.html',
  styleUrls: ['./new-category.component.scss'],
})
export class NewCategoryComponent implements OnInit {
  category = { name: '', description: '', image: null };

  constructor(
    private categoryService: CategoryService,
    private router: Router,
    private mediaService: MediaService
  ) {}

  ngOnInit(): void {}

  newCategory = (): void => {
    this.categoryService.new(this.category).subscribe((response: any) => {
      if (this.category.image)
        this.mediaService.uploadCategoryImage(response.data.slug, this.category.image).subscribe({
          complete: () => { 
            this.router.navigateByUrl('/');
          }
        })
      else this.router.navigateByUrl('/');
    });
  };
}
