import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { UserRole } from 'src/app/enums/UserRole';
import { AuthService } from 'src/app/services/auth.service';
import { CategoryService } from 'src/app/services/category.service';

@Component({
  selector: 'app-category',
  templateUrl: './category.component.html',
  styleUrls: ['./category.component.scss'],
})
export class CategoryComponent implements OnInit {
  category: any = null;
  user: any;
  Admin = UserRole.Admin;

  constructor(
    private categoryService: CategoryService,
    private route: ActivatedRoute,
    private router: Router,
    private auth: AuthService
  ) {}

  ngOnInit(): void {
    this.user = this.auth.getUser();
    let slug = this.route.snapshot.paramMap.get('slug');

    if (slug) {
      this.categoryService.get(slug).subscribe((response: any) => {
        this.category = response.data;
      });
    } else {
      this.router.navigateByUrl('/');
    }
  }

  deleteCategory() {
    this.categoryService.delete(this.category.slug).subscribe(() => {
      this.router.navigateByUrl('/');
    });
  }
}
