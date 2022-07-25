import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { CategoryService } from 'src/app/services/category.service';

@Component({
  selector: 'app-category',
  templateUrl: './category.component.html',
  styleUrls: ['./category.component.scss'],
})
export class CategoryComponent implements OnInit {
  category: any = null;

  constructor(
    private categoryService: CategoryService,
    private route: ActivatedRoute,
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
}
