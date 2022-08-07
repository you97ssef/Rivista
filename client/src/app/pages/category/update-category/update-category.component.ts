import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { CategoryService } from 'src/app/services/category.service';

@Component({
  selector: 'app-update-category',
  templateUrl: './update-category.component.html',
  styleUrls: ['./update-category.component.scss'],
})
export class UpdateCategoryComponent implements OnInit {
  category: any = { name: '', description: '' };

  constructor(
    private route: ActivatedRoute,
    private categoryService: CategoryService,
    private router: Router
  ) {}

  ngOnInit(): void {
    let slug = this.route.snapshot.paramMap.get('slug');

    if (slug) {
      this.categoryService.get(slug).subscribe((response: any) => {
        this.category = response.data;
      });
    } else {
      this.router.navigateByUrl('/');
    }
  }

  updateCategory = (): void => {
    this.categoryService.update(this.category).subscribe((response: any) => {
      this.router.navigateByUrl('/category/' + response.data.slug);
    });
  };
}
